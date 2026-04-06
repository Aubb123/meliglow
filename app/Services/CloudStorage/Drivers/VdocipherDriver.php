<?php

namespace App\Services\CloudStorage\Drivers;

use App\Services\CloudStorage\Contracts\CloudStorageInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VdocipherDriver implements CloudStorageInterface
{
    /**
     * Retourne un client HTTP avec l'authentification Vdocipher
     * Vdocipher utilise "Apisecret" au lieu de "Bearer"
     */
    protected function client(string $apiKey): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Apisecret ' . $apiKey,
            'Content-Type'  => 'application/json',
        ]);
    }

    /**
     * Upload une vidéo vers Vdocipher en 2 étapes :
     * Étape 1 → Obtenir les credentials AWS S3
     * Étape 2 → Upload réel vers AWS S3
     */
    public function upload(UploadedFile $file, array $options = [], ?array $platform): array
    {
        // Vdocipher accepte uniquement les vidéos
        if (!str_starts_with($file->getMimeType(), 'video/')) {
            return [
                'success' => false,
                'error'   => 'Vdocipher accepte uniquement les fichiers vidéo. Type reçu : ' . $file->getMimeType(),
            ];
        }

        try {

            // ============================================================
            // ÉTAPE 1 — Obtenir les credentials d'upload AWS S3
            // ============================================================
            $title = $options['custom_name'] ?? $file->getClientOriginalName();

            $credentialsResponse = $this->client($platform['api_key'])->put("{$platform['api_endpoint']}/videos?title=" . urlencode($title));

            // dd($credentialsResponse->status(), $credentialsResponse->json(), $credentialsResponse->body());

            if ($credentialsResponse->failed()) {
                Log::error('Vdocipher upload step 1 failed', [
                    'status' => $credentialsResponse->status(),
                    'body'   => $credentialsResponse->body(),
                ]);
                return [
                    'success' => false,
                    'error'   => 'Échec de l\'obtention des credentials Vdocipher : ' . $credentialsResponse->body(),
                ];
            }

            $credentials = $credentialsResponse->json();

            // ✅ Structure correcte de la réponse Vdocipher :
            // - videoId     → au niveau racine
            // - clientPayload → contient policy, key, uploadLink, x-amz-*

            $clientPayload = $credentials['clientPayload'] ?? [];
            $videoId       = $credentials['videoId']       ?? null;
            $uploadLink    = $clientPayload['uploadLink']  ?? null;

            if (!$videoId || !$uploadLink) {
                return [
                    'success' => false,
                    'error'   => 'Credentials Vdocipher invalides : videoId ou uploadLink manquant.',
                ];
            }

            $uploadResponse = Http::attach('file',file_get_contents($file->getRealPath()),$file->getClientOriginalName())->post($uploadLink, [
                'policy'                  => $clientPayload['policy'],
                'key'                     => $clientPayload['key'],
                'x-amz-signature'         => $clientPayload['x-amz-signature'],
                'x-amz-credential'        => $clientPayload['x-amz-credential'],
                'x-amz-algorithm'         => $clientPayload['x-amz-algorithm'],
                'x-amz-date'              => $clientPayload['x-amz-date'],
                'success_action_status'   => '201',
                'success_action_redirect' => '',
                // ❌ 'content-type' supprimé — pas dans la policy Vdocipher
            ]);

            // AWS S3 retourne 201 en cas de succès
            if ($uploadResponse->status() !== 201) {
                Log::error('Vdocipher upload step 2 failed', [
                    'status' => $uploadResponse->status(),
                    'body'   => $uploadResponse->body(),
                ]);
                return [
                    'success' => false,
                    'error'   => 'Échec de l\'upload vers AWS S3 : ' . $uploadResponse->body(),
                ];
            }

            return [
                'success'   => true,
                'file_id'   => $videoId,
                'file_name' => $title,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'hash'      => null,
                'url'       => null, // Pas d'URL directe — lecture via OTP
                'direct_url'=> null, // Pas d'URL directe — lecture via OTP
                'thumbnail' => null, // Généré par Vdocipher après traitement
                'type'      => 'video',
                'raw_response' => $credentials,
            ];

        } catch (\Exception $e) {
            Log::error('Vdocipher upload exception', [
                'message' => $e->getMessage(),
                'file'    => $file->getClientOriginalName(),
            ]);
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Supprime une vidéo de Vdocipher
     * DELETE /videos?videos[]={videoId}
     */
    public function delete(string $fileId, bool $deleteForever, ?array $platform): bool
    {
        try {

            $response = $this->client($platform['api_key'])
                ->delete("{$platform['api_endpoint']}/videos", [
                    'videos' => [$fileId],
                ]);

            if ($response->failed()) {
                Log::error('Vdocipher delete failed', [
                    'status'   => $response->status(),
                    'body'     => $response->body(),
                    'video_id' => $fileId,
                ]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Vdocipher delete exception', [
                'message'  => $e->getMessage(),
                'video_id' => $fileId,
            ]);
            return false;
        }
    }

    /**
     * Génère un OTP pour lire la vidéo
     * POST /videos/{videoId}/otp
     * 
     * Note : L'OTP est utilisé avec le player Vdocipher côté frontend :
     * https://player.vdocipher.com/v2/?otp={otp}&playbackInfo={videoId_base64}
     */
    public function getShareableLink(string $fileId, array $options = [], ?array $platform = null): ?string
    {
        try {

            $response = $this->client($platform['api_key'])
                ->post("{$platform['api_endpoint']}/videos/{$fileId}/otp", [
                    'ttl'            => $options['ttl']            ?? 300,   // Durée de vie en secondes (5 min par défaut)
                    'annotate'       => $options['annotate']       ?? '',    // Watermark texte (ex: email de l'utilisateur)
                    'whitelistHref'  => $options['whitelistHref']  ?? '',    // Domaine autorisé
                    'ipGeoRules'     => $options['ipGeoRules']     ?? '',    // Règles géographiques
                ]);

            if ($response->failed()) {
                Log::error('Vdocipher OTP generation failed', [
                    'status'   => $response->status(),
                    'body'     => $response->body(),
                    'video_id' => $fileId,
                ]);
                return null;
            }

            $otp = $response->json('otp');

            if (!$otp) {
                return null;
            }

            // Construire l'URL du player Vdocipher avec l'OTP
            $playbackInfo = base64_encode(json_encode(['videoId' => $fileId]));

            return "https://player.vdocipher.com/v2/?otp={$otp}&playbackInfo={$playbackInfo}";

        } catch (\Exception $e) {
            Log::error('Vdocipher OTP exception', [
                'message'  => $e->getMessage(),
                'video_id' => $fileId,
            ]);
            return null;
        }
    }

    /**
     * Génère uniquement l'OTP (sans construire l'URL complète)
     * Utile pour le player Vdocipher intégré en iframe
     */
    public function generateOtp(string $videoId, array $platform, array $options = []): ?array
    {
        try {

            $response = $this->client($platform['api_key'])
                ->post("{$platform['api_endpoint']}/videos/{$videoId}/otp", [
                    'ttl'           => $options['ttl']           ?? 300,
                    'annotate'      => $options['annotate']      ?? '',
                    'whitelistHref' => $options['whitelistHref'] ?? '',
                    'ipGeoRules'    => $options['ipGeoRules']    ?? '',
                ]);

            if ($response->failed()) {
                return null;
            }

            $otp = $response->json('otp');

            if (!$otp) {
                return null;
            }

            return [
                'otp'          => $otp,
                'playbackInfo' => base64_encode(json_encode(['videoId' => $videoId])),
            ];

        } catch (\Exception $e) {
            Log::error('Vdocipher generateOtp exception', [
                'message'  => $e->getMessage(),
                'video_id' => $videoId,
            ]);
            return null;
        }
    }

    /**
     * Récupère l'URL de lecture de la vidéo via OTP
     * Utilisé dans getVideoUrl() du modèle — même pattern que getFileUrl() de DrimeDriver
     */
    public function getFileUrl(string $fileId, array $platform): ?string
    {
        $otpData = $this->generateOtp($fileId, $platform);

        if (!$otpData) {
            return null;
        }

        return "https://player.vdocipher.com/v2/?otp={$otpData['otp']}&playbackInfo={$otpData['playbackInfo']}";
    }

    /**
     * Crée un dossier — NON SUPPORTÉ par Vdocipher
     * Retourne un dossier fictif pour respecter l'interface
     * Vdocipher utilise des tags à la place des dossiers
     */
    public function createFolder(string $name, ?string $parentId = null, ?array $platform = null): array
    {
        // Vdocipher n'a pas de système de dossiers
        // On retourne un succès fictif pour ne pas casser l'architecture
        return [
            'success'      => true,
            'folder_id'    => null, // Pas de vrai folder_id
            'folder_name'  => $name,
            'raw_response' => [],
        ];
    }

    /**
     * Supprime un dossier — NON SUPPORTÉ par Vdocipher
     * Retourne true pour respecter l'interface
     */
    public function deleteFolder(string $folderId, bool $deleteForever = true, ?array $platform = null): bool
    {
        // Vdocipher n'a pas de système de dossiers
        return true;
    }

    /**
     * Récupère les informations d'une vidéo
     * GET /videos/{videoId}
     */
    public function getVideoInfo(string $videoId, array $platform): ?array
    {
        try {

            $response = $this->client($platform['api_key'])
                ->get("{$platform['api_endpoint']}/videos/{$videoId}");

            if ($response->failed()) {
                return null;
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Vdocipher getVideoInfo exception', [
                'message'  => $e->getMessage(),
                'video_id' => $videoId,
            ]);
            return null;
        }
    }
}
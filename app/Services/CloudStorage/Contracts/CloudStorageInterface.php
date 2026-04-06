<?php

namespace App\Services\CloudStorage\Contracts;

use Illuminate\Http\UploadedFile;

interface CloudStorageInterface
{
    /**
     * Upload un fichier sur la plateforme cloud
     * 
     * @param UploadedFile $file
     * @param array $options
     * @param array|null $platform (optionnel, peut être utilisé pour passer des informations spécifiques à la plateforme, comme les credentials ou les configurations)
     * @return array
     */
    public function upload(UploadedFile $file, array $options = [], ?array $platform): array;

    /**
     * Supprime un fichier
     * 
     * @param string $fileId
     * @param bool $deleteForever (optionnel, par défaut false)
     * @param array|null $platform (optionnel, peut être utilisé pour passer des informations spécifiques à la plateforme, comme les credentials ou les configurations)
     * @return bool
     */
    public function delete(string $fileId, bool $deleteForever, ?array $platform): bool;

    /**
     * Récupère le lien partageable d'un fichier
     * 
     * @param string $fileId
     * @param array $options
     * @param array|null $platform (optionnel, peut être utilisé pour passer des informations spécifiques à la plateforme, comme les credentials ou les configurations)
     * @return string|null
     */
    public function getShareableLink(string $fileId, array $options = [], ?array $platform = null): ?string;

    // /**
    //  * Liste les fichiers
    //  * 
    //  * @param array $filters
    //  * @return array
    //  */
    // public function listFiles(array $filters = []): array;

    /**
     * Crée un dossier
     * 
     * @param string $name
     * @param string|null $parentId
     * @param array|null $platform (optionnel, peut être utilisé pour passer des informations spécifiques à la plateforme, comme les credentials ou les configurations)
     * @return array
     */
    public function createFolder(string $name, ?string $parentId = null, ?array $platform): array;

    /** 
     * Supprime un dossier
     * 
     * @param string $folderId
     * @param bool $deleteForever (optionnel, par défaut true)
     * @param array|null $platform (optionnel, peut être utilisé pour passer des informations spécifiques à la plateforme, comme les credentials ou les configurations)
     * @return bool
     */
    public function deleteFolder(string $folderId, bool $deleteForever = true, ?array $platform,): bool;



    // /**
    //  * Récupère les informations d'un fichier
    //  * 
    //  * @param string $fileId
    //  * @return array|null
    //  */
    // public function getFileInfo(string $fileId): ?array;
}

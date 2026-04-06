<?php

use App\Helpers\Web\Backend\BackendHelper;
use App\Mail\MailSystem;
use App\Models\User;
use App\Notifications\GlobalNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

if(!function_exists('getEnvFolder')) {
    function getEnvFolder() {
        return env('APP_ENV') == 'local' ? 'storage/' : 'public/storage/';
    }
}

if(!function_exists('getDateTime')) {
    function getDateTime() {
        // $date = Carbon::now();
        $date = Carbon::now()->addHours(1); // + 1 heures
        // $date = Carbon::now()->addHours(2); // + 2 heures
        return $date;
    }
}

if(!function_exists('getDateTimeAddMinutes')) {
    function getDateTimeAddMinutes() {
        // $date = now()->addMinutes(2); // Heure actuel + 2 minutes
        // $date = now()->addMinutes(62); // Heure actuel == now(+1heures) + 2 minutes
        $date = now()->addMinutes(75); // Heure actuel == now(+1heures) + 15 minutes
        return $date;
    }
}

// Function pathDefaultUsers()
if (!function_exists('pathDefaultUsers')) {
    function pathDefaultUsers() {
        return 'others/all/users/images/avatar/default.jpg';
    }
}

// AuthController.php
if(!function_exists('sendEmailOtpCode')) {
    function sendEmailOtpCode($user){
        if($user->email_verified_at) {
            $user_email_verified_at =  Carbon::parse($user->email_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');
            return redirect()->route('back.index')->with('success', "Votre compte est déjà actif depuis le $user_email_verified_at");
        } else {

            // Génération du token
            $token = Str::random(10);
            while (DB::table('account_reset_tokens')->where('token', $token)->exists()) {
                $token = Str::random(10);
            }

            // Génération du code OTP pour l'inscription
            $otp_code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            // Vérification de l'unicité (adapter le nom de la table selon votre structure)
            while (DB::table('account_reset_tokens')->where('otp_code', $otp_code)->exists()) {
                $otp_code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            }

            DB::table('account_reset_tokens')->insert([
                'user_id' => $user->id,
                
                'token' => $token, 
                'otp_code' => $otp_code, 
                'reset_token_expires_at' => getDateTimeAddMinutes(),

                'email' => $user->email, 
                'phone' => null,
                'used_at' => null,
                'expired_at' => null,
                
                'created_at' => getDateTime(), 
                'updated_at' => getDateTime(), 
            ]);
            
            // Récupérer l'email de l'utilisateur 
            $email = $user->email;

            $appName = config('app.name');

            $subject = "Code d'activation de mon compte $appName";

            $message = "<strong>Bonjour et bienvenue sur <span class=\"text-secondary\"> $appName </span> !</strong>";  
            $message .= " Nous sommes ravis de vous accueillir dans notre communauté. Pour finaliser la création de votre compte, veuillez utiliser le code suivant, pour activé votre compte : <br><br> <strong style=\"color: #000000ff; font-size: 24px;\">$otp_code</strong>";
            $message .= "<br><br>Ce code est valide pendant 15 minutes. Veuillez ne pas le partager avec qui que ce soit pour des raisons de sécurité.";
            $message .= "<br><br>Si vous n'êtes pas à l'origine de cette inscription, veuillez ignorer cet e-mail.";
            $message .= "<br><br>Cordialement,<br>L'équipe de $appName ";  
            
            Mail::to($email)->send(new MailSystem($subject, $message));

            return $otp_code;

        }
    }
}

if(!function_exists('sendEmailOtpCodeForgotPassword')) {
    function sendEmailOtpCodeForgotPassword($user){

            // Génération du token unique
            do { $token = Str::random(10);
            } while (DB::table('password_reset_tokens')->where('token', $token)->exists());

            // // Génération du code OTP unique
            do { $otp_code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            } while (DB::table('password_reset_tokens')->where('otp_code', $otp_code)->exists());

            // Insérer le token de réinitialisation
            DB::table('password_reset_tokens')->insert([
                'user_id' => $user->id,
                
                'token' => $token, 
                'otp_code' => $otp_code, 
                'reset_token_expires_at' => getDateTimeAddMinutes(),

                'email' => $user->email, 
                'phone' => null,
                'used_at' => null,
                'expired_at' => null,
                
                'created_at' => getDateTime(), 
                'updated_at' => getDateTime(), 
            ]);
            
            // Récupérer l'email de l'utilisateur 
            $email = $user->email;

            $appName = config('app.name');

            $subject = "Code de réinitialisation de mot de passe $appName";

            $message = "<strong>Bonjour !</strong> Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte <span class=\"text-secondary\"> $appName </span>.";  
            $message = "Pour réinitialiser votre mot de passe, veuillez utiliser le code suivant : <br><br> <strong style=\"color: #000000ff; font-size: 24px;\">$otp_code</strong>";
            $message .= "<br><br>Ce code est valide pendant 15 minutes. Veuillez ne pas le partager avec qui que ce soit pour des raisons de sécurité.";
            $message .= "<br><br>Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet e-mail.";
            $message .= "<br><br>Cordialement,<br>L'équipe de $appName ";
            
            Mail::to($email)->send(new MailSystem($subject, $message));

            return $otp_code;

    }
}

if (!function_exists('send_notification')) {
    function send_notification($notify_the_admins, $notify_the_moderators, $notify_the_users, $notify_the_user, $type_notification, $title, $message, $data = [], $actionUrl = null, $actionText = null, $type = 'info', $icon = null, $createdAt = null, $user = null)
    {
        // Si $notify_the_admins est true, envoyer la notification à tous les administrateurs
        if($notify_the_admins){

            // Récupérer tous les administrateurs (role_id = 1)
            $admins = User::where('role_id', 1)->get();

            if($admins->count() > 0) {
                Notification::send($admins, new GlobalNotification($type_notification, $title, $message, $data, $actionUrl, $actionText, $type, $icon, $createdAt));
            } else {
                Log::warning("Aucun administrateur trouvé pour recevoir la notification : $title"); 
            }
        }

        // Si $notify_the_moderators est true, envoyer la notification à tous les modérateurs
        if($notify_the_moderators){

            // Récupérer tous les dévellopeur (role_id = 2)
            // $devs = User::where('role_id', 2)->get();

            // Récupérer tous les modérateurs (role_id = 3)
            $moderators = User::where('role_id', 3)->get();

            if($moderators->count() > 0) {
                Notification::send($moderators, new GlobalNotification($type_notification, $title, $message, $data, $actionUrl, $actionText, $type, $icon, $createdAt));
            } else {
                Log::warning("Aucun modérateur trouvé pour recevoir la notification : $title"); 
            }
        }

        // Si $notify_the_users est true, envoyer la notification à tous les utilisateurs
        if($notify_the_users){

            // Récupérer tous les utilisateurs sauf les administrateurs (role_id = 1)
            $users = User::where('role_id', '<>', 1)->get();

            if($users->count() > 0) {
                Notification::send($users, new GlobalNotification($type_notification, $title, $message, $data, $actionUrl, $actionText, $type, $icon, $createdAt));
            } else {
                Log::warning("Aucun utilisateur trouvé pour recevoir la notification : $title"); 
            }
        }

        // Si $notify_the_user est true, envoyer la notification à l'utilisateur spécifié dans $user
        if($notify_the_user && isset($user)){
            $user->notify(new GlobalNotification($type_notification, $title, $message, $data, $actionUrl, $actionText, $type, $icon, $createdAt));
        }
        
    }
}

/**
 * Parse et retourne les données formatées d'une notification
 *
 * @param \Illuminate\Notifications\DatabaseNotification $notification
 * @return array
 */
function parseNotification($notification): array {
    $data = is_array($notification->data) ? $notification->data : json_decode($notification->data, true);

    $type = $data['type'] ?? 'info';

    $colorMap = [
        'success' => ['border' => 'border-success', 'badge' => 'bg-success', 'icon-bg' => 'text-success'],
        'warning' => ['border' => 'border-warning', 'badge' => 'bg-warning',  'icon-bg' => 'text-warning'],
        'danger'  => ['border' => 'border-danger',  'badge' => 'bg-danger',   'icon-bg' => 'text-danger'],
        'info'    => ['border' => 'border-info',    'badge' => 'bg-info',     'icon-bg' => 'text-info'],
    ];

    return [
        'data'       => $data,
        'isUnread'   => is_null($notification->read_at),
        'type'       => $type,
        'icon'       => $data['icon']       ?? 'fas fa-bell',
        'title'      => $data['title']      ?? 'Notification',
        'message'    => $data['message']    ?? '',
        'actionUrl'  => $data['actionUrl']  ?? null,
        'actionText' => $data['actionText'] ?? 'Voir',
        // 'createdAt'  => isset($data['createdAt']) ? \Carbon\Carbon::parse($data['createdAt'])->diffForHumans() : $notification->created_at->diffForHumans(),
        'createdAt'  => mb_convert_case(\Carbon\Carbon::parse($data['createdAt'])->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm'), MB_CASE_TITLE, 'UTF-8'),
        'colors'     => $colorMap[$type] ?? $colorMap['info'],
    ];
}


// Function backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// Function backend ////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// Function backend ///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////// Function backend ///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////// Function backend ///////////////////////////////
if(!function_exists('destroy_function')) {
    function destroy_function($entity)
    {
        return BackendHelper::destroy_function($entity);
    }
}

if(!function_exists('getCloudPlatforms')) {
    function getCloudPlatforms()
    {
        return BackendHelper::getCloudPlatforms();
    }
}

// Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////
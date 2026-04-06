<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    
    // Fonction système de connexion, inscription, déconnexion ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Fonction système de connexion, inscription, déconnexion ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Fonction système de connexion, inscription, déconnexion ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Fonction système de connexion, inscription, déconnexion ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Fonction système de connexion, inscription, déconnexion ///////////////////////////////
    
    public function register(): View
    {
        $countries = Country::where('is_active', true)->get();
        
        return view('auth/email/register', compact('countries'));
    }

    public function register_store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'country_token' => ['required', 'exists:countries,token'],
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:25'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:25', 'same:password'],
            'sign_agree_check' => ['required', 'in:1'], // Doit être true
        ]);

        $validatedData = $validator->validated();

        // Récupérer le pays sélectionné
        $countrie = Country::where('token', $validatedData['country_token'])->firstOrFail();

        // Génération du token avec une méthode plus sûre
        do { $token = Str::random(10);
        } while (User::where('token', $token)->exists());

        $user = User::create([
            'token' => $token,
            'countrie_id' => $countrie->id,
            'lastname' => $validatedData['lastname'],
            'firstname' => $validatedData['firstname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => 10, // Rôle par défaut
            'created_at' => getDateTime(),
            'updated_at' => getDateTime(),
        ]);

        // Fonction de vérification et d'envoi de l'email de confirmation
        $otp_code = sendEmailOtpCode($user); // Inexistante pour l'instant

        Auth::login($user);

        // Envoie des notifications
        send_notification(
            true, // notify_the_admins
            false, // notify_the_moderators
            false, // notify_the_users
            false, // notify_the_user
            'new_user_registration', // Type de notification
            'Nouvelle inscription utilisateur', // Titre
            "Un nouvel utilisateur vient de s'inscrire avec l'email : {$user->email}", // Message
            ['user_id' => $user->id, 'user_token' => $user->token, 'user_last_name' => $user->lastname, 'user_first_name' => $user->firstname, 'email' => $user->email], // Data supplémentaire à stocker avec la notification
            route('backend.users.show', ['token' => $user->token]), // URL d'action
            'Voir l\'utilisateur', // Texte du bouton
            'info', // Type de notification (success, info, warning, danger)
            'fas fa-user-plus', // Icône (ex: classe FontAwesome)
            getDateTime(),
            null // $user pour les notifications ciblant un utilisateur spécifique, sinon null
        );

        return redirect()->intended(route('frontend.index'))->with('success', "Inscrit avec succès.");
    }

    public function logout(Request $request): RedirectResponse
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnecté avec succès.');

    }

    public function login(): View
    {
        return view('auth/email/login');
    }

    public function login_store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:25'],
        ]);

        $validatedData = $validator->validated();

        // Vérifier si l'utilisateur existe
        $user = User::where('email', $validatedData['email'])->first();
        
        if (!$user) {
            return redirect()->back()->with('error', "E-mail incorrecte");
        }

        // Vérifier le mot de passe
        if (!Hash::check($validatedData['password'], $user->password)) {
            return redirect()->back()->with('error', "Mot de passe incorrecte");
        }

        Auth::login($user);

        // Si l'email n'est pas vérifié, rediriger vers la page de vérification de l'email
        if (!$user->email_verified_at) {
            //Fonction de vérification et d'envoi de l'e-mail de confirmation de compte
            sendEmailOtpCode($user);
        }
        
        return redirect()->intended(route('frontend.index'))->with('success', "Connecté avec succès.");
    }

    // Function de confirmation d'Email //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function de confirmation d'Email ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function de confirmation d'Email //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function de confirmation d'Email //////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function de confirmation d'Email //////////////////////////////////////////////////////

    public function email_verifie_use_otp(): View|RedirectResponse
    {
        $user = auth()->user();
        if($user && $user->email_verified_at == null){
            $user = User::where('id', $user->id)->firstOrFail();
            if($user){
                return view('auth/email/verify/verify-use-otp', compact('user'));
            }else{
                return abort('404');
            }
        }else{
            $user_email_verified_at =  Carbon::parse($user->email_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');
            return redirect()->route('frontend.index')->with('success', "Votre compte est actif depuis le : $user_email_verified_at");
        }
    }

    public function email_resend(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Si l'email n'est pas encore vérifié
        if ($user->email_verified_at) {

            $userEmailVerifiedAt = Carbon::parse($user->email_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');

            return redirect()->back()->with('info', "Votre compte est déjà actif depuis le : $userEmailVerifiedAt");  
        } 

        // Fonction de vérification et d'envoi de l'e-mail de confirmation
        sendEmailOtpCode($user);

        return redirect()->back()->with('success', 'Un nouvel e-mail de vérification a été envoyé à votre adresse e-mail : ' . $user->email);

    }

    public function email_change(Request $request): RedirectResponse
    {

        $user = auth()->user(); // Utilisateur authentifié 

        // Vérifier si le compte est déjà vérifié
        if ($user->email_verified_at) {
            $user_email_verified_at = Carbon::parse($user->email_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');

            return redirect()->back()->with('info', "Votre compte est déjà actif depuis le : $user_email_verified_at");
        }

        // Validation de l'email
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $validatedData = $validator->validated();

        // Récupérer l'email actuel avant modification
        $old_user_email = $user->email;

        // Vérifier si l'email a changé
        if ($validatedData['email'] === $old_user_email) {
            return redirect()->back()->with('info', 'La nouvelle adresse e-mail est identique à l\'ancienne.');
        }

        // Mettre à jour l'email
        $user->email = $validatedData['email'];
        $user->email_verified_at = null; // Réinitialiser la vérification
        $user->updated_at = getDateTime();
        $user->save();

        // Envoyer l'email de vérification
        $otp_sent = sendEmailOtpCode($user);

        return redirect()->back()->with('success', 'Votre adresse e-mail a été mise à jour. Un e-mail de vérification a été envoyé à : ' . $user->email);

    }

    public function email_confirm(Request $request): RedirectResponse
    {
        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        // Vérifier si le compte est déjà vérifié
        if ($user->email_verified_at) {
            $user_email_verified_at = Carbon::parse($user->email_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');

            return redirect()->back()->with('info', "Votre compte est déjà actif depuis le : $user_email_verified_at");
        }

        // Validation du code OTP
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'string', 'size:6', 'exists:account_reset_tokens,otp_code'],
        ]);

        $validatedData = $validator->validated();

        // Rechercher le code OTP le plus récent
        $verification = DB::table('account_reset_tokens')->orderBy('id', 'DESC')->where('email', $user->email)->firstOrFail();

        if(!$verification) {
            return redirect()->back()->withErrors(['otp_code' => 'Code de vérification non trouvé ou déjà utilisé']);
        }

        // Vérifier que le token n'est pas expiré
        if($verification->expired_at) {
            return redirect()->back()->withErrors(['otp_code' => 'Code de vérification expiré']);
        }

        // Vérifier que le token n'a pas déjà été utilisé
        if($verification->used_at) {
            return redirect()->back()->withErrors(['otp_code' => 'Code de vérification déjà utilisé']);
        }

        // Vérification du code OTP
        if ($verification->otp_code !== $validatedData['otp_code']) {
            return redirect()->back()->withErrors(['otp_code' => 'Code de vérification incorrect']);
        }

        // Vérifier si le code OTP a expiré avec Carbon
        if (Carbon::parse($verification->reset_token_expires_at)->lt(getDateTime())) {

            // Marquer le token comme expiré
            DB::table('account_reset_tokens')->where('id', $verification->id)->where('otp_code', $verification->otp_code)->update([
                'expired_at' => getDateTime(),
                'updated_at' => getDateTime()
            ]);

            return redirect()->back()->withErrors(['otp_code' => 'Code de vérification expiré']);
        }

        // Si tout est bon, activer le compte utilisateur
        // Activer le compte utilisateur
        $user->email_verified_at = getDateTime();
        $user->updated_at = getDateTime();
        $user->save();

        // Marquer le code comme utilisé
        DB::table('account_reset_tokens')->where('id', $verification->id)->where('otp_code', $verification->otp_code)->update([
            'used_at' => getDateTime(),
            'updated_at' => getDateTime(),
        ]);

        return redirect()->route('frontend.index')->with('success', 'Votre adresse e-mail a été vérifiée avec succès. Votre compte est maintenant actif.');
    }

    // Function liée au système de mot de passe oublié ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function liée au système de mot de passe oublié ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function liée au système de mot de passe oublié ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function liée au système de mot de passe oublié ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////// Function liée au système de mot de passe oublié ////////////////////////////////////////
    public function forgot_password(): View
    {
        return view('auth/email/password/forgot-password');
    }

    public function forgot_password_send_link(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:users,email']
        ]);

        $validatedData = $validator->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return redirect()->back()->with('error', "Aucun utilisateur trouvé avec cette adresse e-mail.");
        }

        // Fonction de vérification et d'envoi de l'email de réinitialisation de mot de passe
        $otp_code = sendEmailOtpCodeForgotPassword($user); 

        return redirect()->route('forgot.password.verify.otp', $user->token)->with('success', 'Un e-mail de réinitialisation de mot de passe a été envoyé à : ' . $user->email);
    }

    public function forgot_password_verify_otp($token): View|RedirectResponse
    {
        
        $user = User::where('token', $token)->firstOrFail();

        if(!$user && !$user->email){
            return redirect()->back()->with('error', "Compte non trouvé...");
        }

        return view('auth/email/password/forgot-password-verify-otp', compact('user'));
    }

    public function forgot_password_verify_otp_store(Request $request): RedirectResponse 
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'user_token' => ['required', 'string', 'exists:users,token'],
            'otp_code' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/', 'exists:password_reset_tokens,otp_code'],
        ]);

        $validatedData = $validator->validated();

        // Recherche de l'utilisateur par token
        $user = User::where('token', $validatedData['user_token'])->first();

        if(!$user){
            return redirect()->route('login')->with('error', "Utilisateur non trouvé");
        }

        // Récupération du dernier token de réinitialisation pour ce email
        $verification = DB::table('password_reset_tokens')->where('email', $user->email)->orderBy('id', 'DESC')->first();

        if(!$verification) {
            return redirect()->route('login')->with('error', "Aucune demande de réinitialisation trouvée");
        }

        // Vérifier que le token n'est pas expiré
        if($verification->expired_at) {
            return redirect()->route('login')->with('error', "Code de vérification expiré");
        }

        // Vérifier que le token n'a pas déjà été utilisé
        if($verification->used_at) {
            return redirect()->route('login')->with('error', "Code de vérification déjà utilisé");
        }

        // Vérification du code OTP
        if ($verification->otp_code !== $validatedData['otp_code']) {
            return redirect()->route('login')->with('error', "Code de vérification incorrect");
        }

        // Vérifier si le code OTP a expiré avec Carbon
        if (Carbon::parse($verification->reset_token_expires_at)->lt(getDateTime())) {

            // Marquer le token comme expiré
            DB::table('password_reset_tokens')->where('id', $verification->id)->where('otp_code', $verification->otp_code)->update([
                'expired_at' => getDateTime(),
                'updated_at' => getDateTime()
            ]);

            return redirect()->route('login')->with('error', "Code de vérification expiré");
        }
        
        return redirect()->route('forgot.password.edit.new.password', ['token' => $user->token, 'otp_code' => $validatedData['otp_code']])->with('success', 'Code de vérification validé. Veuillez saisir votre nouveau mot de passe.');

    }

    public function forgot_password_edit_new_password($token, $otp_code): View|RedirectResponse
    {
        $verification = DB::table('password_reset_tokens')->orderBy('id', 'DESC')->where('otp_code', $otp_code)->firstOrFail();

        $user = User::where('token', $token)->firstOrFail();

        if(!$verification || !$user){
            return redirect()->route('login')->with('error', 'Lien invalide');
        }

        if($verification->email !== $user->email){
            return redirect()->route('login')->with('error', 'Mail non correspondant');
        }

        if($verification->used_at){
            return redirect()->route('login')->with('error', 'Code déjà utilisé');
        }

        // Convertir la chaîne de date en objet DateTime
        $reset_token_expires_at = new DateTime($verification->reset_token_expires_at);

        if(new DateTime(getDateTime()) > $reset_token_expires_at){

            // Marquer le token comme expiré
            DB::table('password_reset_tokens')->where('id', $verification->id)->where('otp_code', $verification->otp_code)->update([
                'expired_at' => getDateTime(),
                'updated_at' => getDateTime()
            ]);

            return redirect()->route('login')->with('error', 'Code expiré');                        
        }
        
        return view('auth/email/password/forgot-password-edit-new-password', compact('otp_code', 'token'));
    }

    public function forgot_password_update_new_password(Request $request): RedirectResponse
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'user_token' => ['required', 'string'],
            'otp_code' => ['required', 'string', 'exists:password_reset_tokens,otp_code'], // Token obtenu après vérification OTP
            'password' => ['required', 'string', 'min:8', 'max:25'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:25', 'same:password'],
        ]);

        $validatedData = $validator->validated();

        // Recherche de l'utilisateur par token
        $user = User::where('token', $validatedData['user_token'])->first();
        if (!$user) {
            return redirect()->route('login')->with('error', "Utilisateur non trouvé");
        }

        // Récupération du dernier token de réinitialisation pour ce email
        $verification = DB::table('password_reset_tokens')->orderBy('id', 'DESC')->where('email', $user->email)->first();

        if(!$verification) {
            return redirect()->route('login')->with('error', "Aucune demande de réinitialisation trouvée");
        }

        // Vérifier que le token n'est pas expiré
        if($verification->expired_at) {
            return redirect()->route('login')->with('error', "Code de vérification expiré");
        }

        // Vérifier que le token n'a pas déjà été utilisé
        if($verification->used_at) {
            return redirect()->route('login')->with('error', "Code de vérification déjà utilisé");
        }

        // Vérification du code OTP
        if ($verification->otp_code !== $validatedData['otp_code']) {
            return redirect()->route('login')->with('error', "Code de vérification incorrect");
        }

        // Vérifier si le code OTP a expiré avec Carbon
        if (Carbon::parse($verification->reset_token_expires_at)->lt(getDateTime())) {

            // Marquer le token comme expiré
            DB::table('password_reset_tokens')->where('id', $verification->id)->where('otp_code', $verification->otp_code)->update([
                'expired_at' => getDateTime(),
                'updated_at' => getDateTime()
            ]);

            return redirect()->route('login')->with('error', "Code de vérification expiré");
        }

        // Mettre à jour le mot de passe de l'utilisateur
        $user->password = Hash::make($validatedData['password']);
        $user->updated_at = getDateTime();
        $user->save();

        // Marquer le code comme utilisé
        DB::table('password_reset_tokens')->where('id', $verification->id)->where('otp_code', $verification->otp_code)->update([
            'used_at' => getDateTime(),
            'updated_at' => getDateTime(),
        ]);

        return redirect()->route('login')->with('success', 'Votre mot de passe a été mis à jour avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.');

    }

    // Function de confirmation du Numéro téléphonique //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function de confirmation du Numéro téléphonique ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function de confirmation du Numéro téléphonique //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function de confirmation du Numéro téléphonique //////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function de confirmation du Numéro téléphonique //////////////////////////////////////////////////////
    public function sms_resend(Request $request): View
    {
        try {
            $user = auth()->user();

            // Vérifier si l'utilisateur est authentifié
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Si le numéro de téléphone n'est pas encore vérifié
            if ($user->phone_verified_at === null) {

                // Fonction de vérification et d'envoi de l'email de confirmation
                // $otp_code = sendEmailOtpCode($user); // Inexistante pour l'instant

                // Fonction de vérification et d'envoi du sms de confirmation
                $otp_code = sendSmsOtpCode($user); 

                return response()->json([
                    'success' => true,
                    'message' => "Code envoyé au numéro suivant {$user->phone}, ou par mail {$user->email}",
                ], 200);
            }
            // Si le numéro de téléphone est déjà vérifié
            else {
                $userPhoneVerifiedAt = Carbon::parse($user->phone_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');

                return response()->json([
                    'success' => true,
                    'message' => "Votre compte est actif depuis le : {$userPhoneVerifiedAt}",
                ], 200);
            }

        } catch (\Exception $e) {
            // Log de l'erreur pour le debugging
            \Log::error('Sms resend error: ' . $e->getMessage(), [
                'user_id' => $request->user()?->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'envoi du code',
            ], 500);
        }
    }

    public function phone_change(Request $request): View
    {
        try {
            $user = auth()->user(); // Utilisateur authentifié 

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Vérifier si le compte est déjà vérifié
            if ($user->phone_verified_at !== null) {
                $user_phone_verified_at = Carbon::parse($user->phone_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');

                return response()->json([
                    'success' => false,
                    'message' => "Votre compte est déjà actif depuis le : $user_phone_verified_at",
                    'data' => [
                        'phone_verified_at' => $user->phone_verified_at,
                        'formatted_date' => $user_phone_verified_at // Date formatée pour l'affichage
                    ]
                ], 400);
            }

            // Validation du numéro de téléphone
            $validator = Validator::make($request->all(), [
                'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . $user->id],
            ], [
                // 'phone.regex' => 'Le numéro de téléphone doit être au format international (exemple: +229012345678, +33123456789)',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validatedData = $validator->validated();

            // Récupérer le numéro de téléphone actuel avant modification
            $old_user_phone = $user->phone;

            // Vérifier si le numéro de téléphone a changé
            if ($validatedData['phone'] === $old_user_phone) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le nouveau numéro de téléphone est identique à l\'actuel',
                    'data' => [
                        'current_phone' => $old_user_phone
                    ]
                ], 400);
            }

            // Mettre à jour le numéro de téléphone
            $user->phone = $validatedData['phone'];
            $user->phone_verified_at = null; // Réinitialiser la vérification
            $user->updated_at = getDateTime();
            $user->save();

            // Envoyer le sms de vérification
            try {

                // Fonction de vérification et d'envoi de l'email de confirmation
                // $otp_code = sendEmailOtpCode($user); // Inexistante pour l'instant

                // Fonction de vérification et d'envoi du sms de confirmation
                $otp_code = sendSmsOtpCode($user); 

                return response()->json([
                    'success' => true,
                    'message' => "Numéro de téléphone mis à jour avec succès. Un SMS de confirmation a été envoyé au numéro suivant : {$user->phone}",
                    'data' => [
                        'user' => $user->makeHidden(['password']),
                        'old_phone' => $old_user_phone,
                        'new_phone' => $user->phone,
                        'otp_sent' => $otp_sent !== null, // Indique si l'OTP a été envoyé
                    ]
                ], 200);

            } catch (\Exception $e) {
                // Si l'envoi de SMS échoue, on garde la modification mais on informe l'utilisateur
                Log::error('Erreur envoi OTP lors du changement de téléphone: ' . $e->getMessage());

                return response()->json([
                    'success' => true,
                    'message' => "Numéro de téléphone mis à jour avec succès, mais l'envoi du SMS de confirmation a échoué. Veuillez demander un nouvel envoi.",
                    'data' => [
                        'user' => $user->makeHidden(['password']),
                        'old_phone' => $old_user_phone,
                        'new_phone' => $user->phone,
                        'otp_sent' => false
                    ]
                ], 200);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Données de validation invalides',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur lors du changement de numéro de téléphone: ' . $e->getMessage(), [
                'user_id' => $request->user()?->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Échec de la modification du numéro de téléphone',
                'error' => env('APP_ENV') == 'local' ? $e->getMessage() : null
            ], 500);
        }
    }

    public function phone_confirm(Request $request): View
    {
        try {
            // Validation du code OTP
            $validator = Validator::make($request->all(), [
                'otp_code' => ['required', 'string', 'size:6'], // Changé de 'otp-code' à 'otp_code' pour l'API
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validatedData = $validator->validated();

            $otpCode = $validatedData['otp_code'];
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Vérifier si le compte est déjà vérifié
            if ($user->phone_verified_at !== null) {
                $user_phone_verified_at = Carbon::parse($user->phone_verified_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY à HH:mm:ss');

                return response()->json([
                    'success' => false,
                    'message' => "Votre compte est déjà actif depuis le : $user_phone_verified_at",
                    'data' => [
                        'phone_verified_at' => $user->phone_verified_at,
                        'formatted_date' => $user_phone_verified_at // Date formatée pour l'affichage
                    ]
                ], 400);
            }

            // Rechercher le code OTP le plus récent
            $otpRecord = PhoneResetOtpCode::orderBy('id', 'DESC')->where('user_id', $user->id)->where('otp_code', $otpCode)->where('phone', $user->phone)->first();

            if (!$otpRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Code incorrect',
                    'errors' => [
                        'otp_code' => ['Code incorrect']
                    ]
                ], 422);
            }

            // Vérifier si le code a déjà été utilisé
            if ($otpRecord->use == true) {
                return response()->json([
                    'success' => false,
                    'message' => 'Code déjà utilisé',
                    'errors' => [
                        'otp_code' => ['Ce code a déjà été utilisé']
                    ]
                ], 422);
            }

            // Vérifier l'expiration du code
            $expiresAt = new DateTime($otpRecord->reset_token_expires_at);
            if (new DateTime(getDateTime()) > $expiresAt) {
                return response()->json([
                    'success' => false,
                    'message' => 'Code expiré',
                    'errors' => [
                        'otp_code' => ['Ce code a expiré']
                    ]
                ], 422);
            }

            // Marquer le code comme utilisé
            $otpRecord->use = true;
            $otpRecord->updated_at = getDateTime();
            $otpRecord->save();

            // Activer le compte utilisateur
            $user->phone_verified_at = getDateTime();
            $user->updated_at = getDateTime();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Numéro de téléphone vérifié avec succès',
                'data' => [
                    'user' => $user->makeHidden(['password']),
                    'phone_verified_at' => $user->phone_verified_at,
                    'verified' => true
                ]
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Données de validation invalides',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la confirmation de téléphone: ' . $e->getMessage(), [
                'user_id' => $request->user()?->id,
                'otp_code' => $request->input('otp_code'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Échec de la vérification du téléphone',
                'error' => env('APP_ENV') == 'local' ? $e->getMessage() : null
            ], 500);
        }
    }



















}

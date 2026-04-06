<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    // Function backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function backend ///////////////////////////////
    public function backend_users_index(): View
    {
        $users = User::get();
        return view('backend/pages/users/index', compact('users'));
    }

    public function backend_users_create(): View
    {
        $roles = Role::all();
        $countries = Country::where('is_active', true)->get();

        return view('backend/pages/users/create', compact('roles', 'countries'));
    }

    public function backend_users_store(Request $request): RedirectResponse
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            // Champs obligatoires
            'lastname' => ['required', 'string', 'max:100'],
            'firstname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:25', 'confirmed'],
            'role_token' => ['required', 'exists:roles,token'], 
            'countrie_token' => ['required', 'exists:countries,token'],
            'is_active' => ['required', 'in:0,1'],
            
            // Champs optionnels
            'sexe' => ['nullable', 'in:man,woman'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:300'],
            
            // Réseaux sociaux
            'facebook_link' => ['nullable', 'url', 'max:255'],
            'twitter_link' => ['nullable', 'url', 'max:255'],
            'instagram_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link' => ['nullable', 'url', 'max:255'],
            'youtube_link' => ['nullable', 'url', 'max:255'],
            'tiktok_link' => ['nullable', 'url', 'max:255'],
            'whatsapp_link' => ['nullable', 'url', 'max:255'],
            'website_link' => ['nullable', 'url', 'max:255'],
        ]);
        
        // Récupérer le role grâce au token
        $role = Role::where('token', $validatedData['role_token'])->firstOrFail();

        // Récupérer le pays grâce au token
        $country = Country::where('token', $validatedData['countrie_token'])->firstOrFail();
        
        // Générer un token unique
        $token = Str::random(10);
        while(User::where('token', $token)->exists()) {
            $token = Str::random(10);
        }

        // Création de l'utilisateur
        $user = User::create([
            'token' => $token,
            'lastname' => $validatedData['lastname'],
            'firstname' => $validatedData['firstname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $role->id,
            'countrie_id' => $country->id,
            'is_active' => $validatedData['is_active'],

            // Champs optionnels
            'sexe' => $validatedData['sexe'] ?? null,
            'birth_date' => $validatedData['birth_date'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
            'bio' => $validatedData['bio'] ?? null,
            
            // Réseaux sociaux
            'facebook_link' => $validatedData['facebook_link'] ?? null,
            'twitter_link' => $validatedData['twitter_link'] ?? null,
            'instagram_link' => $validatedData['instagram_link'] ?? null,
            'linkedin_link' => $validatedData['linkedin_link'] ?? null,
            'youtube_link' => $validatedData['youtube_link'] ?? null,
            'tiktok_link' => $validatedData['tiktok_link'] ?? null,
            'whatsapp_link' => $validatedData['whatsapp_link'] ?? null,
            'website_link' => $validatedData['website_link'] ?? null,
        ]);

        return redirect()->route('backend.users.show', $user->token)->with('success', 'Utilisateur créé avec succès');
    }

    public function backend_users_show($token): View
    {
        $user = User::where('token', $token)->firstOrFail();
        return view('backend/pages/users/show', compact('user'));
    }

    public function backend_users_edit($token): View
    {
        $user = User::where('token', $token)->firstOrFail();
        $roles = Role::get();
        $countries = Country::where('is_active', true)->get();

        return view('backend/pages/users/edit', compact('user', 'roles', 'countries'));
    }

    public function backend_users_update(Request $request, $token): RedirectResponse
    {
        // Récupérer l'utilisateur à modifier
        $user = User::where('token', $token)->firstOrFail();

        // Validation des données du formulaire
        $validatedData = $request->validate([
            // Champs obligatoires
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'max:25', 'confirmed'],
            'role_token' => ['required', 'exists:roles,token'], 
            'countrie_token' => ['required', 'exists:countries,token'],
            'is_active' => ['required', 'in:0,1'],
            
            // Champs optionnels
            'sexe' => ['nullable', 'in:man,woman'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            
            // Réseaux sociaux
            'facebook_link' => ['nullable', 'url', 'max:255'],
            'twitter_link' => ['nullable', 'url', 'max:255'],
            'instagram_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link' => ['nullable', 'url', 'max:255'],
            'youtube_link' => ['nullable', 'url', 'max:255'],
            'tiktok_link' => ['nullable', 'url', 'max:255'],
            'whatsapp_link' => ['nullable', 'url', 'max:255'],
            'website_link' => ['nullable', 'url', 'max:255'],
        ]);

        //Récupérer l'email de l'utilisateur
        $old_user_email = $user->email;

        // Récupérer le role grâce au token
        $role = Role::where('token', $validatedData['role_token'])->firstOrFail();

        // Récupérer le pays grâce au token
        $country = Country::where('token', $validatedData['countrie_token'])->firstOrFail();

        // Préparer les données à mettre à jour
        $dataToUpdate = [
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'role_id' => $role->id,
            'countrie_id' => $country->id,
            'is_active' => $validatedData['is_active'],

            // Champs optionnels
            'sexe' => $validatedData['sexe'] ?? null,
            'birth_date' => $validatedData['birth_date'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
            'bio' => $validatedData['bio'] ?? null,
            
            // Réseaux sociaux
            'facebook_link' => $validatedData['facebook_link'] ?? null,
            'twitter_link' => $validatedData['twitter_link'] ?? null,
            'instagram_link' => $validatedData['instagram_link'] ?? null,
            'linkedin_link' => $validatedData['linkedin_link'] ?? null,
            'youtube_link' => $validatedData['youtube_link'] ?? null,
            'tiktok_link' => $validatedData['tiktok_link'] ?? null,
            'whatsapp_link' => $validatedData['whatsapp_link'] ?? null,
            'website_link' => $validatedData['website_link'] ?? null,
        ];

        // Mise à jour du mot de passe seulement s'il est fourni
        if (!empty($validatedData['password'])) {
            $dataToUpdate['password'] = Hash::make($validatedData['password']);
        }

        // Mise à jour de l'utilisateur
        $user->update($dataToUpdate);

        // Rafraîchir l'instance de l'utilisateur
        $user = User::where('id', $user->id)->where('token', $user->token)->firstOrFail();

        //Si l'email de l'utilisateur stocké dans $user est différentes de l'email stocké dans $old_user alors -->
        if($user->email !== $old_user_email){
            $user->email_verified_at = null;
            $user->save();
        }

        return redirect()->route('backend.users.show', $user->token)->with('success', 'Utilisateur modifié avec succès');
    }

    public function backend_users_destroy($token): RedirectResponse
    {
        return redirect()->back()->with('info', "Veuillez désactiver le compte de l'utilisateur en lieu et place de le supprimer ");
    }

    // ...
    public function backend_users_blogs($token): View
    {
        $user = User::where('token', $token)->firstOrFail();
        $blogs = $user->blogs;

        return view('backend/pages/users/others/blogs', compact('user', 'blogs'));
    }

    public function backend_users_comments($token): View
    {
        $user = User::where('token', $token)->firstOrFail();
        $comments = $user->comments;

        return view('backend/pages/users/others/comments', compact('user', 'comments'));
    }

    // Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////
    public function frontend_users_show(): View
    {
        $user = User::where('token', auth()->user()->token)->firstOrFail();

        return view('frontend/pages/users/show', compact('user'));
    }

    public function frontend_users_edit(): View
    {
        $user = User::where('token', auth()->user()->token)->firstOrFail();
        $countries = Country::where('is_active', true)->get();

        return view('frontend/pages/users/edit', compact('user', 'countries'));
    }

    public function frontend_users_update(Request $request): RedirectResponse
    {
        $user = User::where('token', auth()->user()->token)->firstOrFail();

        // Validation des données du formulaire
        $validatedData = $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:255'],
            'sexe' => ['nullable', 'in:man,woman'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'countrie_token' => ['required', 'exists:countries,token'],
            'bio' => ['nullable', 'string', 'max:1000'],

            // Réseaux sociaux
            'facebook_link' => ['nullable', 'url', 'max:255'],
            'twitter_link' => ['nullable', 'url', 'max:255'],
            'instagram_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link' => ['nullable', 'url', 'max:255'],
            'youtube_link' => ['nullable', 'url', 'max:255'],
            'tiktok_link' => ['nullable', 'url', 'max:255'],
            'whatsapp_link' => ['nullable', 'url', 'max:255'],
            'website_link' => ['nullable', 'url', 'max:255'],
        ]);

        // Récupérer le pays grâce au token
        $country = Country::where('token', $validatedData['countrie_token'])->firstOrFail();

        //Récupérer l'email de l'utilisateur
        $old_user_email = $user->email;

        // Mise à jour de l'utilisateur
        User::where('token', $user->token)->update([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'phone' => str_replace(' ', '', $validatedData['phone']), // Retirer tout espace dans le numéro de téléphone
            'sexe' => $validatedData['sexe'],
            'birth_date' => $validatedData['birth_date'],
            'countrie_id' => $country->id,
            'bio' => $validatedData['bio'],

            // Réseaux sociaux
            'facebook_link' => $validatedData['facebook_link'],
            'twitter_link' => $validatedData['twitter_link'],
            'instagram_link' => $validatedData['instagram_link'],
            'linkedin_link' => $validatedData['linkedin_link'],
            'youtube_link' => $validatedData['youtube_link'],
            'tiktok_link' => $validatedData['tiktok_link'],
            'whatsapp_link' => $validatedData['whatsapp_link'],
            'website_link' => $validatedData['website_link'],   

            'updated_at' => getDateTime(),
        ]);
        
        // Rafraîchir l'instance de l'utilisateur
        $user = User::where('id', $user->id)->where('token', $user->token)->firstOrFail();
    
        //Si l'email de l'utilisateur stocké dans $user est différentes de l'email stocké dans $old_user alors -->
        if($user->email !== $old_user_email){
            $user->email_verified_at = null;
            $user->save();

            // Envoi de l'email de vérification
            sendEmailOtpCode($user);

        }

        return redirect()->route('frontend.users.show')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function frontend_users_edit_password(): View
    {
        $user = User::where('token', auth()->user()->token)->firstOrFail();

        return view('frontend/pages/users/password/edit', compact('user'));
    }

    public function frontend_users_update_password(Request $request): RedirectResponse
    {
        $user = $request->user();

        if($user){        
            $validatedData =  $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'string', 'min:8', 'max:25'],
                'password_confirmation' => ['required', 'string', 'min:8', 'max:25', 'same:password'],
            ], [
                'password'. '.required' => 'Le champ mot de passe est obligatoire.',
                'password'. '.string' => 'Le champ mot de passe doit être une chaîne de caractères.',
                'password'. '.min' => 'Le champ mot de passe doit contenir au moins :min caractères.',
                'password'. '.max' => 'Le champ mot de passe ne doit pas dépasser :max caractères.',
                'password'. '.regex' => 'Le champ mot de passe doit contenir au moins 8 caractères, 1 lettre ou chiffre, un symbole spécial',
            ]);

            if($validatedData['password'] == $validatedData['password_confirmation']){
                $request->user()->update([
                    'password' => Hash::make($validatedData['password']),
                    'updated_at' => getDateTime(),
                ]);

                // Déconnexion de l'utilisateur après le changement de mot de passe
                auth()->logout();

                return redirect()->route('login')->with('success', 'Mot de passe modifié avec succès');

            }else{
                return redirect()->back()->with('error', 'Mot de passe non identique');
            }

        }else{
            return redirect()->route('login');
        }
    }

}

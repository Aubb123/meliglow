<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SubscribeController extends Controller
{
   
    // Function backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function backend ///////////////////////////////

    public function backend_subscribes_index(): View
    {
        $subscribes = Subscribe::all();
        return view('backend/pages/subscribes/index', compact('subscribes'));
    }

    public function backend_subscribes_edit($token): View|RedirectResponse
    {
        $subscribe = Subscribe::where('token', $token)->firstOrFail();

        if($subscribe){
            return view('backend/pages/subscribes/edit', compact('subscribe'));
        }else{
            return abort('404');
        }
    } 

    public function backend_subscribes_update(Request $request, $token): RedirectResponse
    { 
        $subscribe = Subscribe::where('token', $token)->firstOrFail();

        $validatedData = $request->validate([
            'etat' => ['required', 'in:0,1'],
        ]);

        if($subscribe){
            // Mise à jour
            Subscribe::where('id', $subscribe->id)->where('token', $token)->update([
                'etat' => $validatedData['etat'],
                'updated_at' => getDateTime(),
            ]);

            if($validatedData['etat'] == true && $subscribe->etat == false){
                return redirect()->route('backend.subscribes.index')->with('success', "Email: '$subscribe->email', réabonnée avec succès.");
            }

            if($validatedData['etat'] == false && $subscribe->etat == true){
                return redirect()->route('backend.subscribes.index')->with('success', "Email: '$subscribe->email', désabonnée avec succès.");
            }

            return redirect()->route('backend.subscribes.index');

        }else{
            return abort('404');
        }

    }

    public function backend_subscribes_destroy($token): RedirectResponse
    {
        $subscribe = Subscribe::where('token', $token)->firstOrFail();

        if($subscribe){

            if($subscribe->etat == true){
                return redirect()->route('backend.subscribes.index')->with('error', "Veuillez désabonné l'email: '$subscribe->email', avant sa suppression.");
            }

            if($subscribe->etat == false){
                //Suppression
                destroy_function($subscribe, 'Abonnée');

                return redirect()->route('backend.subscribes.index')->with('success', "Abonnée supprimer avec succès");
            }

        }else{
            return abort('404');
        }
    } 

    // Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////


    public function frontend_subscribe_store(Request $request): RedirectResponse 
    {
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $verification = Subscribe::where('email', $validatedData['email'])->exists();

        if($verification){

            $subscribe = Subscribe::where('email', $validatedData['email'])->firstOrFail();

            if($subscribe && $subscribe->etat == false){

                Subscribe::where('email', $validatedData['email'])->update([
                    'etat' => true, // FALSE = Désabonner; TRUE = Abonner
                    'updated_at' => getDateTime(), 
                ]);

                return redirect()->back()->with('success', 'Réabonnée avec succès.');

            }

            if($subscribe && $subscribe->etat == true){
                return redirect()->back()->with('warning', 'Déjà abonnée');
            }

        }else{

            $token = Str::random(10);
            while(Subscribe::where('token', $token)->exists()) {
                $token = Str::random(10);
            }

            Subscribe::create([
                'token' => $token,
                'user_id' => $request->user() ? $request->user()->id : null,
                'email' => $validatedData['email'],
                'etat' => true, // FALSE = Désabonner; TRUE = Abonner
                'created_at' => getDateTime(), 
                'updated_at' => getDateTime(), 
            ]);
            
            return redirect()->back()->with('success', 'Abonnée avec succès.');

        }


    }
}

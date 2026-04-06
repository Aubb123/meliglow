<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
     // Function backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function backend ///////////////////////////////
    public function backend_contacts_index(): View
    {
        $contacts = Contact::all();
        return view('backend/pages/contacts/Index', compact('contacts'));
    }

    public function backend_contacts_show($token): View
    {
        $contact = Contact::where('token', $token)->firstOrFail();
        
        return view('backend/pages/contacts/Show', compact('contact'));
    }

    public function backend_contacts_destroy($token): RedirectResponse
    {
        $contact = Contact::where('token', $token)->firstOrFail();
        if($contact){
            
            //Suppression
            destroy_function($contact, 'Contacts');

            return redirect()->route('backend.contacts.index')->with('success', "Supprimer avec succès");
        }else{
            return abort('404');
        }
    }

     // Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////

    public function frontend_contacts_store(Request $request): RedirectResponse 
    {  
        $validatedData = $request->validate([ 
            'fullname' => ['required', 'string', 'min:2','max:100'], 
            'email' => ['required', 'email', 'string', 'min:5','max:255'], 
            'phone' => ['required', 'min:2','max:50'], 
            'message' => ['required', 'min:2','max:1000'], 
        ]); 
        
        $token = Str::random(10);
        while(Contact::where('token', $token)->exists()) {
            $token = Str::random(10);
        }

        $contact = Contact::create([ 
            'fullname' => $validatedData['fullname'], 
            'email' => $validatedData['email'], 
            'phone' => $validatedData['phone'], 
            'message' => $validatedData['message'], 
            'user_id' => $request->user() ? $request->user()->id : null, 
            'token' => $token, 
            'created_at' => getDateTime(), 
            'updated_at' => getDateTime(), 
        ]);

        return redirect()->back()->with('success', 'Merci de nous avoir contactés ! Nous avons bien reçu votre message, un retour vous sera fait par courriel électronique.');

    }

}

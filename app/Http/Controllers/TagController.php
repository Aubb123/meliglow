<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TagController extends Controller
{
    // Fonction backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Fonction backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Fonction backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Fonction backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Fonction backend ///////////////////////////////

    public function backend_tags_index(): View
    {
        $tags = Tag::get();
        return view('backend/pages/tags/index', compact('tags'));
    }

    public function backend_tags_create(): View
    {
        return view('backend/pages/tags/create');
    }

    public function backend_tags_store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'min:2', 'max:100', 'unique:tags,name'],
        ]);

        $token = Str::random(10);
        while(Tag::where('token', $token)->exists()) {
            $token = Str::random(10);
        }

        $tag = Tag::create([  
            'name' => Str::lower($validatedData['name']),
            'token' => $token,
            'created_at' => getDateTime(), 
            'updated_at' => getDateTime(), 
        ]);

        return redirect()->route('backend.tags.index')->with('success', 'Balise tag créer avec succès');
    }

    // public function backend_tags_show($token): View
    // {  
    //     $tag = Tag::where('token', $token)->firstOrFail();
    //     return view('backend/pages/tags/Show', compact('tag'));
    // }

    public function backend_tags_edit($token): View
    {  
        $tag = Tag::where('token', $token)->firstOrFail();
        return view('backend/pages/tags/Edit', compact('tag'));
    }

    public function backend_tags_update(Request $request, $token): RedirectResponse
    {   
        $tag = Tag::where('token', $token)->firstOrFail();

            $validatedData = $request->validate([
                'name' => ['required', 'min:2', 'max:100', 'unique:tags,name,'.$tag->id],
            ]);

            Tag::where('id', $tag->id)->where('token', $token)->update([  
                'name' => Str::lower($validatedData['name']),
                'updated_at' => getDateTime(), 
            ]);

        return redirect()->route('backend.tags.index')->with('success', 'Balise tag mise à jour avec succès');
    }

    public function backend_tags_destroy($token): RedirectResponse 
    {
        $tag = Tag::where('token', $token)->first();

        if($tag){
            //Suppression
            destroy_function($tag, 'Tags');

            return redirect()->route('backend.tags.index')->with('success', "Balise tag supprimer avec succès");
        }else{
            return redirect()->back()->with('error', 'Balise tag non trouvée.');
        }
        
    }
    
    // ...

    public function backend_tags_blogs($token): View
    {  
        $tag = Tag::where('token', $token)->firstOrFail();
        $blogs = $tag->blogs;

        return view('backend/pages/tags/others/blogs', compact('tag', 'blogs'));
    }
}

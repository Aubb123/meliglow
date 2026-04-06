<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Categorie;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
   
    // Function backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function backend ///////////////////////////////

    public function backend_blogs_index(): View
    {
        $blogs = Blog::get();
        return view('backend/pages/blogs/index', compact('blogs'));
    }

    public function backend_blogs_create(): View
    {
        $categories = Categorie::all();
        $tags = Tag::all();
        return view('backend/pages/blogs/create', compact('categories', 'tags'));
    }
    
    public function backend_blogs_store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:100', 'unique:blogs,title'],
            'content' => ['required', 'string', 'min:5'],
            'path_img' => ['required', 'image', 'mimes:png,jpg', 'max:5000'],
            'time_read' => ['required', 'numeric'],
            'is_visible' => ['required', 'in:0,1'],
            'categorie_token' => ['required', 'exists:categories,token'],
            'tags_token' => ['required', 'array'],
            'tags_token.*' => ['exists:tags,token'],
        ]);
        
        // Récupération de la catégorie à base du 'token'
        $categorie = Categorie::where('token', $validatedData['categorie_token'])->firstOrFail();

        // Récupérer les Balises à base des 'token'
        $tags = Tag::whereIn('token', $validatedData['tags_token'])->get();
        if($tags->count() > 5){ // Vérifier si trop de balise tag n'a pas été sélectionner
            return redirect()->back()->with('info', "Trop de balise tag sélectionnée. 05 maximum");
        }

        if ($request->hasFile('path_img')) {
            // Générer un nom de fichier unique basé sur la date et l'heure
            $path_img = Str::random(50);
            $fileName = "image_du_" . getDateTime()->format('d_M_Y-H_i_s') . "_" . $path_img . "." . $validatedData['path_img']->getClientOriginalExtension();

            // Stocker le fichier avec le nouveau nom dans le dossier spécifié
            $filepath_img = Storage::disk('public')->putFileAs('others/all/blogs/images', $validatedData['path_img'], $fileName);
        }else{
            return redirect()->back()->with('info', "Erreur, Image du blog requis");
        }

        // Traitement "is_visible"
        if($validatedData['is_visible'] == 0){
            $is_visible = false;
        }
        if($validatedData['is_visible'] == 1){
            $is_visible = true;
        }

        $token = Str::random(10);
        while(Blog::where('token', $token)->exists()) {
            $token = Str::random(10);
        }
        
        $blog = Blog::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'path_img' => $filepath_img,
            'token' => $token, 
            'time_read' => $validatedData['time_read'],
            'is_visible' => $is_visible,
            'user_id' => $request->user()->id,
            'categorie_id' => $categorie->id,
            'created_at' => getDateTime(), 
            'updated_at' => getDateTime(), 
        ]);

        // // Synchroniser des tags (remplace les tags existants)
        // $blog->tags()->sync($tagIds); // Remplace les tags existants par ces tags
        $blog->tags()->attach($tags, ['created_at' => getDateTime(), 'updated_at' => getDateTime()]);

        return redirect()->route('backend.blogs.show', $blog->token)->with('success', 'Article de blog créer avec succès.');
    }

    public function backend_blogs_show($token): View
    {
        $blog = Blog::where('token', $token)->firstOrFail();
        $comments = $blog->comments()->paginate(10);

        return view('backend/pages/blogs/show', [
            'blog' => $blog,
            'comments' => $comments,
        ]);
    }

    public function backend_blogs_edit($token): View
    {
        $blog = Blog::where('token', $token)->firstOrFail();
        $categories = Categorie::all();
        $tags = Tag::all();

        return view('backend/pages/blogs/edit', compact('categories', 'tags', 'blog'));
    }

    public function backend_blogs_update(Request $request, $token): RedirectResponse
    {  
        $blog = Blog::where('token', $token)->firstOrFail();

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:100', 'unique:blogs,title,' . $blog->id],
            'content' => ['required', 'string'],
            'path_img' => ['nullable', 'image', 'mimes:png,jpg', 'max:5000'],
            'time_read' => ['required', 'numeric'],
            'is_visible' => ['required', 'in:0,1'],
            'categorie_token' => ['required', 'exists:categories,token'],
            'tags_token' => ['required', 'array'],
            'tags_token.*' => ['exists:tags,token'],
        ]);
        
        // Récupération de la catégorie à base du 'token'
        $categorie = Categorie::where('token', $validatedData['categorie_token'])->firstOrFail();

        // Récupérer les Balises à base des 'token'
        $tags = Tag::whereIn('token', $validatedData['tags_token'])->get();
        if($tags->count() > 5){ // Vérifier si trop de balise tag n'a pas été sélectionner
            return redirect()->back()->with('info', "Trop de balise tag sélectionnée. 05 maximum");
        }

        if ($request->hasFile('path_img')) {
            // Générer un nom de fichier unique basé sur la date et l'heure
            $path_img = Str::random(50);
            $fileName = "image_du_" . getDateTime()->format('d_M_Y-H_i_s') . "_" . $path_img . "." . $validatedData['path_img']->getClientOriginalExtension();

            // Stocker le fichier avec le nouveau nom dans le dossier spécifié
            $filepath_img = Storage::disk('public')->putFileAs('others/all/blogs/images', $validatedData['path_img'], $fileName);

            if ($blog->path_img && $blog->path_img !== 'others/all/blogs/images/default.jpg') {
                // Suppression de l'ancienne image
                Storage::disk('public')->delete($blog->path_img);
            }

        }else{
            
            $filepath_img = $blog->path_img;
        }
        
        // Traitement "is_visible"
        if($validatedData['is_visible'] == 0){
            $is_visible = false;
        }
        if($validatedData['is_visible'] == 1){
            $is_visible = true;
        }

        Blog::where('id', $blog->id)->where('token', $token)->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'path_img' => $filepath_img,
            'time_read' => $validatedData['time_read'],
            'is_visible' => $is_visible, 
            'categorie_id' => $categorie->id,
            'updated_at' => getDateTime(), 
        ]);

        // Détache méthode (supprimer)
        $blog->tags()->detach();
        // Ensuite attacher (Associer) les tags au blog
        // $blog->tags()->sync($tags, ['created_at' => getDateTime(), 'updated_at' => getDateTime()]);
        $blog->tags()->attach($tags, ['created_at' => getDateTime(), 'updated_at' => getDateTime()]);

        return redirect()->route('backend.blogs.show', $blog->token)->with('success', 'Article de blog mise à jour avec succès.');
    }

    public function backend_blogs_destroy($token): RedirectResponse
    {
        // Rechercher le blog à supprimer en utilisant le token
        $blog = Blog::where('token', $token)->first();

        if($blog->is_visible == true){
            return redirect()->back()->with('error', "Veuillez masqué le blog, avant de procéder à sa suppression.");
        }

        if($blog->is_visible == false){
            // Si des commentaires sont liées ce blog 
            if($blog->comments->count() > 0) {
                return redirect()->back()->with('warning', "Veuillez supprimer toutes les commentaire(s) liée(s) à ce blog, avant de procéder à la suppression du blog");
            } else {
                
                //Suppression
                destroy_function($blog, 'Blogs');

                return redirect()->route('backend.blogs.index')->with('success', "Article de blog supprimer avec succès");
            }
        }
        
    }

    // ...

    public function backend_blogs_comments($token): View
    {
        $blog = Blog::where('token', $token)->firstOrFail();
        $comments = $blog->comments;

        return view('backend/pages/blogs/others/comments', compact('blog', 'comments'));
    }

    public function backend_blogs_replies($token): View
    {
        $blog = Blog::where('token', $token)->firstOrFail();
        $comments = $blog->comments;
       
        // Rassembler toutes les réponses
        $replies = $comments->flatMap(function ($comment) {
            return $comment->replys;
        });

        return view('backend/pages/blogs/others/replies', compact('blog', 'replies'));

        // $repliesCount = \App\Models\Reply::whereIn('comment_id', $blog->comments()->pluck('id'))->count();

    }

    // Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////

    public function frontend_blogs_index(): View|RedirectResponse
    {

        // Faire un redirect vers la page d'accueil
        return redirect()->route('frontend.index')->with('info', "Bientôt disponible !");

        $blogs = Blog::where('is_visible', true)->orderBy('created_at', 'desc')->paginate(9);

        return view('frontend/pages/blogs/index', compact('blogs'));
    }

    public function frontend_blogs_show($token): View
    {
        $blog = Blog::where('token', $token)->where('is_visible', true)->firstOrFail();

        $comments = $blog->comments()->where('is_visible', true)->paginate(10);

        // Vérifier si l'utilisateur est authentifié
        if (auth()->check()) {
            // Utiliser le token utilisateur au lieu du name (plus fiable et unique)
            $key = 'user_' . auth()->user()->token . '_blog_viewed_' . $blog->token;

            // Vérifier si ce blog a déjà été vu par cet utilisateur
            if (!session()->has($key)) {
                // Incrémenter le compteur de vues
                $blog->increment('views');
                // Marquer ce blog comme vu dans la session
                session([$key => true]);
            }

        } else {
            // Cas des invités (non authentifiés)
            // On utilise l'adresse IP pour limiter les incréments multiples
            $key = 'guest_' . request()->ip() . '_blog_viewed_' . $blog->token;

            if (!session()->has($key)) {
                $blog->increment('views');
                session([$key => true]);
            }
        }

        // Récupérer les tags et les catégories
        $tags = Tag::all();
        $categories = Categorie::all();

        return view('frontend/pages/blogs/show', compact('blog', 'comments', 'tags', 'categories'));
    }

    // ... Ajoutez d'autres méthodes frontend si nécessaire

    public function frontend_blogs_categories($token): View
    {
        $categorie = Categorie::where('token', $token)->firstOrFail();

        $blogs = Blog::where('categorie_id', $categorie->id)->where('is_visible', true)->orderBy('created_at', 'desc')->paginate(9);

        return view('frontend/pages/blogs/index', compact('blogs'));
    }

    public function frontend_blogs_tags($token): View
    {
        $tag = Tag::where('token', $token)->firstOrFail();

        $blogs = $tag->blogs()->where('is_visible', true)->orderBy('created_at', 'desc')->paginate(9);

        return view('frontend/pages/blogs/index', compact('blogs'));
    }

    public function frontend_blogs_search(Request $request): View
    {
        $searchTerm = $request->input('query');

        $blogs = Blog::where('is_visible', true)->where(function($query) use ($searchTerm) {
            $query->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('content', 'LIKE', '%' . $searchTerm . '%');
        })->orderBy('created_at', 'desc')->paginate(9);

        return view('frontend/pages/blogs/index', compact('blogs'));
    }

}


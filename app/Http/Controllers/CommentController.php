<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    // Function backend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function backend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function backend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function backend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function backend ///////////////////////////////

    public function backend_comments_index(): View
    {
        $comments = Comment::get();
        return view('backend/pages/comments/index', compact('comments'));
    }

    public function backend_comments_show($token): View|RedirectResponse
    {
        $comment = Comment::where('token', $token)->firstOrFail();
        if($comment->commentable){
            
            $replies = $comment->replys;
            $blog = $comment->commentable; // Accéder au blog via la relation polymorphe

            return view('backend/pages/comments/show', compact('comment', 'replies', 'blog'));
        }else{
            return redirect()->back()->with('info', "Référence du commentaire non trouvé: 'blog' ou  ");
        }
    }

    public function backend_comments_update(Request $request, $token): RedirectResponse
    {
        $comment = Comment::where('token', $token)->firstOrFail();

        $validatedData = $request->validate([
            'is_visible' => ['required','in:0,1'], // 0 = Masqué 1 = Démasqué
        ]);

        if($comment->commentable){

            if ($validatedData['is_visible'] == 0) {

                Comment::where('token', $token)->update([  
                    'is_visible' => false,
                    'updated_at' => getDateTime(), 
                ]);

                return redirect()->route('backend.comments.show', $comment->token)->with('success', 'Commentaire masqué avec succès.');
            } 
            
            if ($validatedData['is_visible'] == 1) {
                Comment::where('token', $token)->update([  
                    'is_visible' => true,
                    'updated_at' => getDateTime(), 
                ]);

                return redirect()->route('backend.comments.show', $comment->token)->with('success', 'Commentaire démasqué avec succès.');
            }
            
        }else{
            return redirect()->back()->with('info', "Référence du commentaire non trouvé: 'blog', 'formation', ou 'chapitre' ");
        }
    }

    public function backend_comments_destroy($token): RedirectResponse
    {
        $comment = Comment::where('token', $token)->firstOrFail();

        // Vérifier si aucune réponse n'est liée au commentaire
        // if($comment->replys->count() > 0){
        //     return redirect()->back()->with('warning', "Veuillez supprimer toutes les réponses liées a ce commentaire avant de procéder a la suppression du commentaire.");
        // }

        if($comment->is_visible == true){
            return redirect()->back()->with('error', "Veuillez masqué le commentaire, avant de procéder à sa suppression.");
        }

        if($comment->is_visible == false){
           //Suppression
           destroy_function($comment, 'Commentaires');

           return redirect()->route('backend.comments.index')->with('success', "Commentaire supprimer avec succès");
        }
    }

    // ...

    public function backend_comments_replies($token): View
    {
        $comment = Comment::where('token', $token)->firstOrFail();
        $replies = $comment->replys;

        return view('backend/pages/comments/others/replies', compact('comment', 'replies'));

        // $repliesCount = \App\Models\Reply::whereIn('comment_id', $comment->comments()->pluck('id'))->count();

    }

    // Function frontend ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////// Function frontend ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////// Function frontend ///////////////////////////////

    public function frontend_comments_store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'commentable_id' => ['required', 'integer'],
            'commentable_type' => ['required', 'string', 'in:App\Models\Blog'], // On peut ajouter d'autres types comme 'App\Models\Formation', 'App\Models\Chapitre'
            'content' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        if($validatedData['commentable_type'] === 'App\Models\Blog'){
            $commentable = Blog::find($validatedData['commentable_id']);
            // $blog = Blog::find($validatedData['commentable_id']);
            // dd(get_class($blog));
        }else{
            return redirect()->back()->with('error', "Type de commentaire non valide.");
        }

        if (!$commentable) {
            return redirect()->back()->with('error', "L'élément que vous essayez de commenter n'existe pas.");
        }
        
        $token = Str::random(10);
        while(Comment::where('token', $token)->exists()) {
            $token = Str::random(10);
        }

        $newComment = Comment::create([
            'token' => $token,
            'user_id' => auth()->id(),
            'content' => $validatedData['content'],
            'commentable_id' => $validatedData['commentable_id'],
            'commentable_type' => $validatedData['commentable_type'],
            'is_visible' => true, // Par défaut, le commentaire est visible
            'created_at' => getDateTime(),
            'updated_at' => getDateTime(),
        ]);

        return redirect()->back()->with('success', "Votre commentaire a été publié avec succès.");
    }

    // Supprimer un commentaire (seulement par l'utilisateur qui l'a posté)
    public function frontend_comments_destroy($token): RedirectResponse
    {
        $comment = Comment::where('token', $token)->firstOrFail();  

        if ($comment->user_id !== auth()->id()) {
            return redirect()->back()->with('error', "Vous n'êtes pas autorisé à supprimer ce commentaire.");
        }

        $comment->delete();

        return redirect()->back()->with('success', "Votre commentaire a été supprimé avec succès.");
    }
}

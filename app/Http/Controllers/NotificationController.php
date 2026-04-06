<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{

    // Afficher toutes les notifications
    public function frontend_notifications_index(): View
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Récupérer les notifications de l'utilisateur connecté, paginées
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(20);

        $unreadCount = $user->unreadNotifications()->count();

        return view('frontend/pages/notifications/index', compact('notifications', 'user', 'unreadCount'));
    }

    // Supprimer une notification
    public function frontend_notifications_destroy($id): RedirectResponse
    {
        return redirect()->back()->with('error', 'La suppression des notifications est désactivée pour éviter les suppressions accidentelles. Veuillez contacter l\'administrateur si vous souhaitez supprimer une notification.');

        // Récupérer l'utilisateur connecté
        $user = auth()->user();
        
        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification supprimée');
    }

    // Marquer une notification comme lue
    public function frontend_notifications_mark_read(Request $request, string $id)
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        $redirect = $request->query('redirect');
        return $redirect ? redirect($redirect) : back()->with('success', 'Notification marquée comme lue.');
    }

    // Marquer toutes comme lues
    public function frontend_notifications_mark_all_read(): RedirectResponse
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();
        
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

}

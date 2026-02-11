<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('statut', '!=', 'En attente');

        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        
        if ($request->filled('status')) {
            $query->where('statut', $request->status);
        }

        // Récupérer le nombre d'utilisateurs en attente
        $pendingUsers = User::where('statut', 'En attente')->count();

        // Récupérer les utilisateurs filtrés, paginés et triés
        $users = $query->where('role', '!=', 'Éditeur')
                      ->orderBy('created_at', 'desc')
                      ->paginate(12)
                      ->withQueryString(); // Garde les paramètres de filtrage dans la pagination

        return view('admin.users.index', compact('users', 'pendingUsers'));
    }

    public function pendingRequests()
    {
        $users = User::where('statut', 'En attente')
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);

        return view('admin.users.pending', compact('users'));
    }

    public function approveUser(User $user)
    {
        if ($user->statut !== 'En attente') {
            return back()->with('error', 'Cet utilisateur n\'est pas en attente d\'approbation.');
        }

        $user->update([
            'statut' => 'Actif',
            'email_verified_at' => now()
        ]);

        return back()->with('success', 'Utilisateur approuvé avec succès.');
    }

    public function rejectUser(User $user)
    {
        if ($user->statut !== 'En attente') {
            return back()->with('error', 'Cet utilisateur n\'est pas en attente d\'approbation.');
        }

        $user->delete();

        return back()->with('success', 'Demande d\'inscription rejetée.');
    }

    public function block(User $user)
    {
        if ($user->role === 'Éditeur') {
            return back()->with('error', 'Vous ne pouvez pas bloquer un Editeur.');
        }

        $user->update(['statut' => 'Inactif']);

        return back()->with('success', 'Utilisateur bloqué avec succès.');
    }

    public function unblock(User $user)
    {
        $user->update(['statut' => 'Actif']);

        return back()->with('success', 'Utilisateur débloqué avec succès.');
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->role === 'Éditeur') {
            return back()->with('error', 'Vous ne pouvez pas modifier le rôle d\'un Super Admin.');
        }

        $request->validate([
            'role' => 'required|in:Abonné,Responsable de thème,Éditeur'
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'Éditeur') {
            return back()->with('error', 'Vous ne pouvez pas supprimer un Super Admin.');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
} 
//     }
// } 
<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Responsable de thème') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $theme = Auth::user()->managedTheme;
        
        $subscribers = $theme->subscribers()
            ->withPivot('date_abonnement')
            ->orderBy('subscriptions.date_abonnement', 'desc')
            ->paginate(10);

        $totalSubscribers = $theme->subscribers()->count();

        return view('responsable.members.index', compact('subscribers', 'totalSubscribers'));
    }

    public function remove(User $user)
    {
        $theme = Auth::user()->managedTheme;
        
        if (!$theme->subscribers->contains($user)) {
            return back()->with('error', 'Cet utilisateur n\'est pas abonné à votre thème.');
        }

        $theme->subscribers()->detach($user->id);
        return back()->with('success', 'Abonné retiré avec succès.');
    }
} 
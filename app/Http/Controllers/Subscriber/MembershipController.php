<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $themes = Theme::all();
        $subscribedThemeIds = $user->subscribedThemes()
            ->pluck('theme_id')
            ->toArray();

        return view('subscriber.memberships.index', [
            'themes' => $themes,
            'subscribedThemeIds' => $subscribedThemeIds
        ]);
    }

    public function subscribe(Theme $theme)
    {
        $user = Auth::user();
        
        if (!$user->subscribedThemes()->where('theme_id', $theme->id)->exists()) {
            $user->subscribedThemes()->attach($theme->id, [
                'date_abonnement' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Vous êtes maintenant abonné au thème : {$theme->nom_theme}"
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Vous êtes déjà abonné à ce thème'
        ]);
    }

    public function unsubscribe(Theme $theme)
    {
        $user = Auth::user();
        
        if ($user->subscribedThemes()->where('theme_id', $theme->id)->exists()) {
            $user->subscribedThemes()->detach($theme->id);
            
            return response()->json([
                'success' => true,
                'message' => "Vous êtes maintenant désabonné du thème : {$theme->nom_theme}"
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => "Vous n'êtes pas abonné à ce thème"
        ]);
    }
} 
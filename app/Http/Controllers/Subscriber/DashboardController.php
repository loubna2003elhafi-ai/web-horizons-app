<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $data = [
            'articlesCount' => $user->articles()->count(),
            'subscriptionsCount' => $user->subscribedThemes()->count(),
            'readArticlesCount' => $user->navigationHistory()->count(),
            'recentActivities' => $user->navigationHistory()
                ->with(['article' => function($query) {
                    $query->select('id', 'titre', 'date_publication');
                }])
                ->latest()
                ->take(5)
                ->get()
        ];



        return view('subscriber.dashboard', $data);
    }
} 

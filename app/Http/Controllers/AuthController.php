<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function showLoginForm(){
        return view("auth.login");
    }

    function showRegistrationForm(){
        return view("auth.register");
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Récupérer l'utilisateur par email
        $user = User::where('email', $request->email)->first();


        // Vérifier si l'utilisateur existe et son statut
        if (!$user) { 
            return back()->withErrors([
                'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
            ]);
        }

        // Vérifier le statut de l'utilisateur
        if ($user->statut === 'en attente') {
            return redirect()->route('auth.pending')
                ->with('message', 'Votre compte est en attente de validation.');
        }

        if ($user->statut === 'inactif') { 
            return back()->withErrors([
                'email' => 'Votre compte a été désactivé. Veuillez contacter l\'administrateur.',
            ]);
        }

        // Tenter la connexion
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            // Debug pour vérifier le rôle après connexion
            \Log::info('Authenticated user role: ' . Auth::user()->role);
            
            // Redirection selon le rôle
            return match($user->role) {
                'Éditeur' => redirect()->route('editor.dashboard'),
                'Responsable de thème' => redirect()->route('responsable.dashboard'),
                'Abonné' => redirect()->route('subscriber.dashboard'),
                default => redirect()->route('home'),
            };
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $nom = $request->prenom . ' ' . $request->nom;

        $user = User::create([
            'nom' => $nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Abonné',
            'statut' => 'en attente',
            'date_inscription' => now(),
        ]);

        return redirect()->route('auth.pending')->with('message', 'Votre inscription est en attente de validation.');
    }

    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route("login"));
    }

    public function showPendingPage()
    {
        return view('auth.pending');
    }
}

<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function show(Article $article)
    {
        $messages = $article->conversations()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('subscriber.discussions.show', [
            'article' => $article,
            'messages' => $messages
        ]);
    }

    public function store(Request $request, Article $article)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $article->conversations()->create([
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Message envoyé');
    }
} 
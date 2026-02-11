<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Subscriber\DashboardController;
use App\Http\Controllers\Subscriber\ArticleController;
use App\Http\Controllers\Subscriber\ReadingHistoryController;
use App\Http\Controllers\Subscriber\MembershipController;
use App\Http\Controllers\Subscriber\DiscussionController;
use App\Http\Controllers\Subscriber\SubmissionController;

// use App\Http\Controllers\ThemeManager\DashboardController as ThemeManagerDashboardController;
// use App\Http\Controllers\ThemeManager\ContentController as ThemeManagerContentController;
// use App\Http\Controllers\ThemeManager\MembershipController as ThemeManagerMembershipController;
// use App\Http\Controllers\ThemeManager\ModeratorController;
use App\Http\Controllers\Responsable\ContentController as ResponsableContentController;
use App\Http\Controllers\Responsable\DashboardController as ResponsableDashboardController;
use App\Http\Controllers\Responsable\MembershipController as ResponsableMembershipController;
use App\Http\Controllers\Responsable\ModeratorController as ResponsableDiscussionController;


use App\Http\Controllers\editeur\DashboardController as AdminDashboardController;
use App\Http\Controllers\editeur\NumeroController as EditorIssueController;
use App\Http\Controllers\editeur\UserController;
use App\Http\Controllers\editeur\ArticleController as EditorArticleController;

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{article}', [HomeController::class, 'showArticle'])->name('public.articles.show');

// Auth routes
Route::middleware('guest')->group(function () { 
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/pending', [AuthController::class, 'showPendingPage'])->name('auth.pending');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // abonné routes
    Route::prefix('subscriber')->name('subscriber.')->middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Articles
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
        Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
        Route::post('/articles/{article}/rate', [ArticleController::class, 'rate'])->name('articles.rate');
        Route::post('/articles/{article}/comment', [ArticleController::class, 'comment'])->name('articles.comment');
        
        // Historique de lecture
        Route::get('/history', [ReadingHistoryController::class, 'index'])->name('history');
        
        // Abonnements aux thèmes
        Route::get('/subscriptions', [MembershipController::class, 'index'])->name('subscriptions');
        Route::post('/subscriptions/{theme}', [MembershipController::class, 'subscribe'])->name('subscriptions.subscribe');
        Route::delete('/subscriptions/{theme}', [MembershipController::class, 'unsubscribe'])->name('subscriptions.unsubscribe');

        // Discussions
        Route::get('/discussions/{article}', [DiscussionController::class, 'show'])->name('discussions.show');
        Route::post('/discussions/{article}', [DiscussionController::class, 'store'])->name('discussions.store');

        // Routes pour les propositions d'articles
        Route::prefix('submissions')->name('submissions.')->group(function () {
            Route::get('/', [SubmissionController::class, 'index'])->name('index');
            Route::get('/create', [SubmissionController::class, 'create'])->name('create');
            Route::post('/', [SubmissionController::class, 'store'])->name('store');
            Route::get('/{article}', [ArticleController::class, 'show'])->name('show');
            Route::delete('/{article}', [SubmissionController::class, 'delete'])->name('destroy');
        });
    });



    // Theme Manager routes
    Route::prefix('responsable')->name('responsable.')->middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [ResponsableDashboardController::class, 'index'])->name('dashboard');
        
        // Gestion du contenu/articles
        Route::prefix('content')->name('content.')->group(function () {
            Route::get('/', [ResponsableContentController::class, 'index'])->name('index');
            Route::get('/show/{article}', [ResponsableContentController::class, 'show'])->name('show');
            Route::post('/accept/{article}', [ResponsableContentController::class, 'accept'])->name('accept');
            Route::post('/reject/{article}', [ResponsableContentController::class, 'reject'])->name('reject');
            Route::post('/propose/{article}', [ResponsableContentController::class, 'proposeForPublication'])->name('propose');
        });
        
        // Gestion des abonnés
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [ResponsableMembershipController::class, 'index'])->name('index');
            Route::delete('/{user}', [ResponsableMembershipController::class, 'remove'])->name('remove');
        });
        
        // Gestion de la modération
        Route::prefix('moderation')->name('moderation.')->group(function () {
            // Route::get('/', [ResponsableDiscussionController::class, 'index'])->name('index');
            Route::post('/comment/{article}', [ResponsableDiscussionController::class, 'addComment'])->name('comment');
            Route::delete('/message/{message}', [ResponsableDiscussionController::class, 'deleteMessage'])->name('delete-message');
        });
    });



    // Editor routes
    Route::prefix('editor')->name('editor.')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Articles à valider
        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [EditorArticleController::class, 'index'])->name('index');
            Route::get('/{article}', [EditorArticleController::class, 'show'])->name('show');
            Route::post('/{article}/toggle-status', [EditorArticleController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{article}/assign-to-numero', [EditorArticleController::class, 'assignToNumero'])->name('assign-to-numero');
            Route::delete('/{article}', [EditorArticleController::class, 'destroy'])->name('destroy');
        });

        // Gestion des numéros
        Route::prefix('issues')->name('issues.')->group(function () {
            Route::get('/', [EditorIssueController::class, 'index'])->name('index');
            Route::get('/create', [EditorIssueController::class, 'create'])->name('create');
            Route::post('/', [EditorIssueController::class, 'store'])->name('store');
            Route::get('/{numero}/edit', [EditorIssueController::class, 'edit'])->name('edit');
            Route::put('/{numero}', [EditorIssueController::class, 'update'])->name('update');
            Route::delete('/{numero}', [EditorIssueController::class, 'destroy'])->name('destroy');
            Route::post('/{numero}/publish', [EditorIssueController::class, 'publish'])->name('publish');
            Route::post('/{numero}/unpublish', [EditorIssueController::class, 'unpublish'])->name('unpublish');
            Route::post('/{numero}/toggle-visibility', [EditorIssueController::class, 'toggleVisibility'])->name('toggle-visibility');
        });

        // Gestion des utilisateurs
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/pending', [UserController::class, 'pendingRequests'])->name('pending');
            Route::post('/{user}/approve', [UserController::class, 'approveUser'])->name('approve');
            Route::post('/{user}/reject', [UserController::class, 'rejectUser'])->name('reject');
            Route::post('/{user}/block', [UserController::class, 'block'])->name('block');
            Route::post('/{user}/unblock', [UserController::class, 'unblock'])->name('unblock');
            Route::post('/{user}/update-role', [UserController::class, 'updateRole'])->name('update-role');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            
        });
    });
});




?>








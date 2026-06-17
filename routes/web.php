<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\SellerMiddleware;
use App\Models\AuditLog;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['lv', 'en'])) {
        Session::put('locale', $locale);
        Session::save();

        App::setLocale($locale);

        return redirect()->route('listing.index');
    }

    return redirect()->route('listing.index');
})->name('lang.switch');

// Guest
Route::get('/', [ListingController::class, 'index'])->name('listing.index');
Route::get('/search', [ListingController::class, 'search'])->name('listing.search');

Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/listings/create', [ListingController::class, 'create'])->name('listing.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listing.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listing.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listing.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listing.destroy');
    Route::post('/listings/{listing}/mark-as-sold', [ListingController::class, 'markAsSold'])->name('listing.markAsSold');

    Route::get('/messages', [MessageController::class, 'list'])->name('message.list');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('message.show');
    Route::post('/messages/{user}', [MessageController::class, 'send'])->name('message.send');
    Route::post('/listings/{listing}/message', [MessageController::class, 'sendFromListing'])->name('message.sendFromListing');


    Route::middleware([SellerMiddleware::class])->prefix('seller')->group(function () {
        Route::get('/listings', [ListingController::class, 'myListings'])->name('listing.myListings');
    });

    Route::middleware(['admin'])->prefix('admin')->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/listings', [AdminController::class, 'listings'])->name('admin.listings');
        Route::delete('/listings/{listing}', [AdminController::class, 'deleteListing'])->name('admin.deleteListing');

        // Bloķēšanas darbības tavā panelī
        Route::post('/users/{user}/block', [AdminController::class, 'blockUser'])->name('admin.blockUser');
        Route::post('/users/{user}/unblock', [AdminController::class, 'unblockUser'])->name('admin.unblockUser');

        // Kategorijas
        Route::post('/categories', [AdminController::class, 'createCategory'])->name('admin.createCategory');
        Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.deleteCategory');
        Route::get('/categories/manage', [AdminController::class, 'manageCategories'])->name('admin.createOrDeleteCategory');

        // Audita žurnāli
        Route::get('/audit-logs', function () {
            $logs = AuditLog::with('user')->latest()->paginate(20);
            return view('admin.audit_logs', compact('logs'));
        })->name('admin.audit_logs');
    });
});

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listing.show');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display admin dashboard with users and listings
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalListings = Listing::count();
        $totalCategories = Category::count();

        $recentUsers = User::latest()->limit(10)->get();
        $recentListings = Listing::latest()->limit(10)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalListings', 'totalCategories', 'recentUsers', 'recentListings'));
    }

    /**
     * Display all users for management
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    /**
     * Display all listings for moderation
     */
    public function listings()
    {
        $listings = Listing::latest()->paginate(15);
        return view('admin.listings', compact('listings'));
    }

    /**
     * Delete a listing (moderation)
     */
    public function deleteListing(Listing $listing)
    {
        $listing->delete();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete_listing',
            'description' => "Administrators izdzēsa sludinājumu: '{$listing->title}' (ID: {$listing->id})",
            'model_type' => Listing::class,
            'model_id' => $listing->id,
        ]);

        return back()->with('success', 'Listing deleted successfully!');
    }

    /**
     * Block a user
     */
    public function blockUser(User $user)
    {
        $user->update(['blocked' => true]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'block_user',
            'description' => "Administrators nobloķēja lietotāju: {$user->name} (ID: {$user->id})",
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        return back()->with('success', 'User blocked successfully!');
    }

    /**
     * Unblock a user
     */
    public function unblockUser(User $user)
    {
        $user->update(['blocked' => false]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'unblock_user',
            'description' => "Administrators nobloķēja lietotāju: {$user->name} (ID: {$user->id})",
            'model_type' => User::class,
            'model_id' => $user->id,
        ]);

        return back()->with('success', 'User unblocked successfully!');
    }

    /**
     * Create a new category
     */
    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        $category = Category::create($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create_category',
            'description' => "Administrators izveidoja kategoriju: '{$category->name}' (ID: {$category->id})",
            'model_type' => Category::class,
            'model_id' => $category->id,
        ]);
        return back()->with('success', 'Category created successfully!');
    }

    /**
     * Delete a category
     */
    public function deleteCategory(Category $category)
    {

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete_category',
            'description' => "Administrators izdzesa kategoriju: '{$category->name}' (ID: {$category->id})",
            'model_type' => Category::class,
            'model_id' => $category->id,
        ]);

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
    public function manageCategories()
    {
        $categories = Category::all();

        return view('admin.categories', compact('categories'));
    }
}

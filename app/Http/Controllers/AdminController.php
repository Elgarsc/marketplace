<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Routing\Controller;

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
        return back()->with('success', 'Listing deleted successfully!');
    }

    /**
     * Block a user
     */
    public function blockUser(User $user)
    {
        $user->update(['blocked' => true]);

        return back()->with('success', 'User blocked successfully!');
    }

    /**
     * Unblock a user
     */
    public function unblockUser(User $user)
    {
        $user->update(['blocked' => false]);
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

        Category::create($validated);
        return back()->with('success', 'Category created successfully!');
    }

    /**
     * Delete a category
     */
    public function deleteCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
    public function manageCategories()
    {
        $categories = Category::all();

        return view('admin.categories', compact('categories'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;
use App\Models\ListingImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'search']);
    }

    /**
     * Display all listings
     */
    public function index(Request $request)
    {
        $listings = Listing::latest()->paginate(12);

        return view('listing.index', compact('listings'));
    }

    public function myListings()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Now the editor knows $user has a listings() method!
        $listings = $user->listings()->latest()->paginate(12);

        return view('listing.myListings', compact('listings'));
    }

    /**
     * Show the form for creating a new listing
     */
    public function create()
    {
        $this->authorize('create', Listing::class);

        $categories = Category::all();
        return view('listing.create', compact('categories'));
    }

    /**
     * Store a newly created listing in storage
     */
    public function store(Request $request)
    {
        $this->authorize('create', Listing::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing = Listing::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('listing.show', $listing)->with('success', 'Listing created successfully!');
    }

    /**
     * Display the specified listing
     */
    public function show(Listing $listing)
    {
        $listing->load('user', 'category', 'images');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Now your editor and Laravel both know what favorites() is!
        $isFavorited = $user && $user->favorites()->where('listing_id', $listing->id)->exists();

        return view('listing.show', compact('listing', 'isFavorited'));
    }

    /**
     * Show the form for editing the specified listing
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);

        $categories = Category::all();
        return view('listing.edit', compact('listing', 'categories'));
    }

    /**
     * Update the specified listing in storage
     */
    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('listing.show', $listing)->with('success', 'Listing updated successfully!');
    }

    /**
     * Delete the specified listing
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        // Delete images
        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $listing->delete();

        return redirect()->route('listing.index')->with('success', 'Listing deleted successfully!');
    }

    /**
     * Search listings by keyword, category, or price
     */
    public function search(Request $request)
    {
        $query = Listing::query();

        if ($request->has('keyword') && $request->keyword) {
            $query->search($request->keyword);
        }

        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        if ($request->has('min_price') && $request->min_price) {
            $minPrice = floatval($request->min_price);
            $maxPrice = $request->has('max_price') && $request->max_price ? floatval($request->max_price) : PHP_INT_MAX;
            $query->byPriceRange($minPrice, $maxPrice);
        }

        $listings = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('listing.search', compact('listings', 'categories'));
    }
}

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
use App\Services\CurrencyService;
use App\Models\AuditLog;

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
        $listings = Listing::where('status', 'active')->latest()->paginate(12);
        $categories = Category::all();
        $recentlySold = Listing::where('status', 'sold')->orderBy('updated_at', 'desc')->take(3)->get();

        return view('listing.index', compact('listings', 'recentlySold', 'categories'));
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
            'currency' => 'required|in:EUR,USD',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing = Listing::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'currency' => $validated['currency'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                ]);
            }
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'create_listing',
            'description' => "Lietotājs izveidoja sludinājumu: '{$listing->title}' (ID: {$listing->id})",
        ]);

        return redirect()->route('listing.show', $listing)->with('success', 'Listing created successfully!');
    }

    /**
     * Display the specified listing
     */


    public function show(Listing $listing, CurrencyService $currencyService)
    {
        $listing->load('user', 'category', 'images');

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $isFavorited = $user && $user->favorites()->where('listing_id', $listing->id)->exists();

        // Dinamiski konvertējam pretējo valūtu, balstoties uz to, kas ir DB
        $converted = $currencyService->getConvertedData($listing->price, $listing->currency);

        return view('listing.show', compact('listing', 'isFavorited', 'converted'));
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
            'currency' => 'required|in:EUR,USD', // Validējam valūtu
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $listing->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'currency' => $validated['currency'], // Saglabājam izmaiņas datubāzē
            'category_id' => $validated['category_id'],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => $path,
                ]);
            }
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'update_listing',
            'description' => "Lietotājs atjaunināja sludinājumu: '{$listing->title}' (ID: {$listing->id})",
        ]);

        return redirect()->route('listing.show', $listing)->with('success', 'Listing updated successfully!');
    }

    /**
     * Delete the specified listing
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);


        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $listing->delete();

        return redirect()->route('listing.index')->with('success', 'Listing deleted successfully!');
    }

    public function markAsSold(Listing $listing)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->id !== $listing->user_id && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $listing->update([
            'status' => 'sold'
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'marked_as_sold',
            'model_type' => Listing::class,
            'model_id' => $listing->id,
            'description' => ($user->is_admin ? 'Admin' : 'Owner') . ' marked listing "' . $listing->title . '" as sold.'
        ]);

        return redirect()->route('listing.index')->with('success', 'Listing marked as sold!');
    }


    /**
     * Search listings by keyword, category, or price
     */
    public function search(Request $request)
    {
        $query = Listing::query()->where('status', '!=', 'sold');

        if ($request->filled('keyword')) {
            $query->search($request->keyword);
        }

        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->filled('min_price') ? floatval($request->min_price) : 0;
            $maxPrice = $request->filled('max_price') ? floatval($request->max_price) : PHP_INT_MAX;

            $query->byPriceRange($minPrice, $maxPrice);
        }

        $listings = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::all();

        $recentlySold = collect();

        return view('listing.search', compact('listings', 'categories', 'recentlySold'));
    }
}

<x-layout>

    <div class="container mt-5">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-md-8">
                <h1 class="display-4 mb-3">Browse Marketplace</h1>
                <p class="lead text-muted">Discover amazing items from sellers in your area</p>
            </div>
            <div class="col-md-4 text-end">
                @auth
                @can('create', App\Models\Listing::class)
                <a href="{{ route('listing.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Create Listing
                </a>
                @endcan
                @else
                <a href="{{ route('auth.register') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus"></i> Get Started
                </a>
                @endauth
            </div>
        </div>

        <!-- Search Section -->
        <div class="row mb-5">
            <div class="col-md-12">
                <form action="{{ route('listing.search') }}" method="GET" class="card p-4 shadow-sm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="Search by keyword...">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="number"
                                name="min_price"
                                class="form-control"
                                placeholder="Min Price"
                                step="0.01"
                                min="0">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="number"
                                name="max_price"
                                class="form-control"
                                placeholder="Max Price"
                                step="0.01"
                                min="0">
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="electronics">Electronics</option>
                                <option value="furniture">Furniture</option>
                                <option value="clothing">Clothing</option>
                                <option value="books">Books</option>
                                <option value="sports">Sports</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Listings Grid -->
        <div class="row">
            @forelse($listings as $listing)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm listing-card">
                    <!-- Image -->
                    <div class="position-relative" style="overflow: hidden; height: 200px;">
                        @if($listing->images->count() > 0)
                        <img
                            src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                            alt="{{ $listing->title }}"
                            class="listing-image">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center listing-image">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">
                        <!-- Category Badge -->
                        <span class="badge bg-secondary mb-2">
                            {{ $listing->category->name ?? 'Uncategorized' }}
                        </span>

                        <!-- Title -->
                        <h5 class="card-title text-truncate">
                            {{ $listing->title }}
                        </h5>

                        <!-- Price -->
                        <p class="card-text text-primary fw-bold fs-5 mb-2">
                            {{ $listing->currency === 'EUR' ? '€' : '$' }}{{ number_format($listing->price, 2) }}
                        </p>

                        <!-- Seller Info -->
                        <p class="card-text small text-muted mb-3">
                            <i class="bi bi-person-circle"></i> {{ $listing->user->name }}
                        </p>

                        <!-- Description Preview -->
                        <p class="card-text small text-muted flex-grow-1 mb-3">
                            {{ Str::limit($listing->description, 100) }}
                        </p>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('listing.show', $listing) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-eye"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <h5>No listings found</h5>
                    <p class="mb-0">Check back soon or create your own listing!</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($listings->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                {{ $listings->links() }}
            </div>
        </div>
        @endif
    </div>

    @if($recentlySold->isNotEmpty())
    <div class="row mb-5">
        <div class="col-12 border-bottom pb-2 mb-4">
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-bag-check-fill text-danger me-2"></i>Recently Sold
            </h3>
            <p class="text-muted small mb-0">Deals you just missed! See what has recently left the marketplace.</p>
        </div>

        <div class="row g-4">
            @foreach($recentlySold as $soldItem)
            <div class="col-md-4">
                <div class="card h-100 border-light-subtle shadow-sm bg-light-subtle opacity-75 position-relative" style="transform: none !important;">

                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm text-uppercase fw-bold" style="z-index: 2;">
                        <i class="bi bi-bookmark-dash-fill me-1"></i> Sold
                    </span>

                    <div class="card-body d-flex flex-column pt-5">
                        <div class="flex-grow-1">
                            <h5 class="card-title text-decoration-line-through text-muted fw-bold mb-1">
                                {{ $soldItem->title }}
                            </h5>
                            <p class="text-secondary small mb-3">
                                {{ Str::limit($soldItem->description, 70) }}
                            </p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-light-subtle">
                            <span class="text-dark fw-bold">${{ number_format($soldItem->price, 2) }}</span>
                            <small class="text-muted italic" style="font-size: 11px;">
                                Sold {{ $soldItem->updated_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <style>
        .listing-card {
            transition: all 0.3s ease;
        }

        .listing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
</x-layout>
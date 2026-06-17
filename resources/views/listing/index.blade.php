<x-layout>

    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-8">
                <h1 class="display-4 mb-3">{{ __('messages.listings.index.browse_title') }}</h1>
                <p class="lead text-muted">{{ __('messages.listings.index.browse_sub') }}</p>
            </div>
            <div class="col-md-4 text-end">
                @auth
                @can('create', App\Models\Listing::class)
                <a href="{{ route('listing.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> {{ __('messages.listings.index.create_listing') }}
                </a>
                @endcan
                @else
                <a href="{{ route('auth.register') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus"></i> {{ __('messages.listings.index.get_started') }}
                </a>
                @endauth
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12">
                <form action="{{ route('listing.search') }}" method="GET" class="card p-4 shadow-sm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="{{ __('messages.listings.index.search_keyword') }}">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="number"
                                name="min_price"
                                class="form-control"
                                placeholder="{{ __('messages.listings.index.min_price') }}"
                                step="0.01"
                                min="0">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="number"
                                name="max_price"
                                class="form-control"
                                placeholder="{{ __('messages.listings.index.max_price') }}"
                                step="0.01"
                                min="0">
                        </div>
                        <div class="col-md-2">
                            <select name="category_id" class="form-select">
                                <option value="">{{ __('messages.listings.index.all_categories') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> {{ __('messages.listings.index.search_btn') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($listings as $listing)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm listing-card">
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
                        <span class="badge bg-secondary mb-2">
                            {{ $listing->category->name ?? __('messages.listings.index.uncategorized') }}
                        </span>

                        <h5 class="card-title text-truncate">
                            {{ $listing->title }}
                        </h5>

                        <p class="card-text text-primary fw-bold fs-5 mb-2">
                            {{ $listing->currency === 'EUR' ? '€' : '$' }}{{ number_format($listing->price, 2) }}
                        </p>

                        <p class="card-text small text-muted mb-3">
                            <i class="bi bi-person-circle"></i> {{ $listing->user->name }}
                        </p>

                        <p class="card-text small text-muted flex-grow-1 mb-3">
                            {{ Str::limit($listing->description, 100) }}
                        </p>

                        <div class="d-grid gap-2">
                            <a href="{{ route('listing.show', $listing) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-eye"></i> {{ __('messages.listings.index.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <h5>{{ __('messages.listings.index.no_listings') }}</h5>
                    <p class="mb-0">{{ __('messages.listings.index.no_listings_sub') }}</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($listings->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                {{ $listings->links() }}
            </div>
        </div>
        @endif
    </div>

    @if($recentlySold->isNotEmpty())
    <div class="container">
        <div class="row mb-5 mt-5">
            <div class="col-12 border-bottom pb-2 mb-4">
                <h3 class="fw-bold text-dark mb-1">
                    <i class="bi bi-bag-check-fill text-danger me-2"></i>{{ __('messages.listings.index.recently_sold') }}
                </h3>
                <p class="text-muted small mb-0">{{ __('messages.listings.index.recently_sold_sub') }}</p>
            </div>

            <div class="row g-4">
                @foreach($recentlySold as $soldItem)
                <div class="col-md-4">
                    <div class="card h-100 border-light-subtle shadow-sm bg-light-subtle opacity-75 position-relative" style="transform: none !important;">

                        <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm text-uppercase fw-bold" style="z-index: 2;">
                            <i class="bi bi-bookmark-dash-fill me-1"></i> {{ __('messages.listings.index.sold_badge') }}
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
                                <span class="text-dark fw-bold">
                                    {{ $soldItem->currency === 'EUR' ? '€' : '$' }}{{ number_format($soldItem->price, 2) }}
                                </span>
                                <small class="text-muted italic" style="font-size: 11px;">
                                    {{ __('messages.listings.index.sold_at', ['time' => $soldItem->updated_at]) }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
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
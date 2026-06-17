<x-layout>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-8">
                <h1 class="display-5 mb-3">{{ __('messages.search.title') }}</h1>
                <p class="lead text-muted">{{ __('messages.search.sub') }}</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('listing.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('messages.search.back_btn') }}
                </a>
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
                                placeholder="{{ __('messages.search.keyword_placeholder') }}"
                                value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="number"
                                name="min_price"
                                class="form-control"
                                placeholder="{{ __('messages.search.min_price') }}"
                                step="0.01"
                                min="0"
                                value="{{ request('min_price') }}">
                        </div>
                        <div class="col-md-2">
                            <input
                                type="number"
                                name="max_price"
                                class="form-control"
                                placeholder="{{ __('messages.search.max_price') }}"
                                step="0.01"
                                min="0"
                                value="{{ request('max_price') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">{{ __('messages.search.all_categories') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> {{ __('messages.search.search_btn') }}
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
                            {{ $listing->category->name ?? __('messages.search.uncategorized') }}
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

                        <p class="card-text small text-muted mb-3">
                            <i class="bi bi-calendar"></i> {{ $listing->created_at->format('M d, Y') }}
                        </p>

                        <div class="d-grid gap-2">
                            <a href="{{ route('listing.show', $listing) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-eye"></i> {{ __('messages.search.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="bi bi-search" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">{{ __('messages.search.no_results') }}</h5>
                    <p class="mb-0">{{ __('messages.search.no_results_sub') }}</p>
                    <a href="{{ route('listing.index') }}" class="btn btn-primary mt-3">
                        {{ __('messages.search.view_all_btn') }}
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        @if($listings->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                {{ $listings->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>

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
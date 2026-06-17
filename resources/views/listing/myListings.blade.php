<x-layout>
    <div class="container py-5">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center border-bottom pb-4 mb-5 gap-3">
            <div>
                <h1 class="fw-bold text-dark mb-1">{{ __('messages.listings.my_listings') }}</h1>
            </div>
            <a href="{{ route('listing.create') }}" class="btn btn-primary align-items-center px-4 py-2">
                <i class="bi bi-plus-lg me-2"></i>
                {{ __('messages.listings.create_listing') }}
            </a>
        </div>

        @if($listings->count())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
            @foreach($listings as $listing)
            <div class="col">
                <div class="card h-100 border-light shadow-sm overflow-hidden flex-column">
                    <a href="{{ route('listing.show', $listing) }}" class="d-block position-relative bg-light border-bottom text-center" style="height: 200px;">
                        @if($listing->images->first())
                        <img src="{{ asset('storage/' . $listing->images->first()->image_path) }}" alt="{{ $listing->title }}" class="w-100 h-100 object-fit-cover transition-all">
                        @else
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-secondary gap-2">
                            <i class="bi bi-image text-muted fs-2"></i>
                            <span class="small text-muted">{{ __('messages.listings.no_image') }}</span>
                        </div>
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column">
                        <div class="flex-grow-1">
                            <a href="{{ route('listing.show', $listing) }}" class="card-title h5 d-block text-decoration-none text-dark fw-bold mb-2 text-primary-hover">
                                {{ $listing->title }}
                            </a>
                            <p class="card-text text-muted small mb-0 text-truncate-2" style="height: 40px; overflow: hidden;">
                                {{ Str::limit($listing->description, 100) }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="h5 fw-black text-primary mb-0">${{ number_format($listing->price, 2) }}</span>

                            <div class="d-flex gap-2">
                                <a href="{{ route('listing.edit', $listing) }}" class="btn btn-sm bg-primary text-white px-3 d-inline-flex align-items-center">
                                    <i class="bi bi-pencil me-1"></i> {{ __('messages.listings.edit') }}
                                </a>

                                <form action="{{ route('listing.destroy', $listing) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-danger text-white px-3 d-inline-flex align-items-center">
                                        <i class="bi bi-trash me-1"></i> {{ __('messages.listings.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $listings->links() }}
        </div>
        @else
        <div class="card text-center py-5 px-4 max-w-md mx-auto border-light-subtle shadow-sm mt-4">
            <div class="card-body">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-archive fs-3"></i>
                </div>
                <h3 class="h5 fw-bold text-dark">{{ __('messages.listings.no_listings_yet') }}</h3>
                <p class="text-muted small mb-4">{{ __('messages.listings.create_first_listing_sub') }}</p>
                <a href="{{ route('listing.create') }}" class="btn btn-primary shadow-sm px-4 d-inline-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-lg me-2"></i> {{ __('messages.listings.create_first_listing_btn') }}
                </a>
            </div>
        </div>
        @endif
    </div>
</x-layout>
<x-layout>
    <div class="container mt-5">
        <div class="mb-4">
            <a href="{{ route('listing.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('messages.show.back_btn') }}
            </a>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                @if($listing->images->count() > 0)
                <div id="listingImageCarousel" class="carousel slide card shadow-sm" data-bs-ride="carousel">

                    <div class="carousel-inner">
                        @foreach($listing->images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img
                                src="{{ asset('storage/' . $image->image_path) }}"
                                class="d-block w-100 rounded"
                                alt="Listing Image"
                                style="max-height: 500px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>

                    @if($listing->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#listingImageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#listingImageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
                @else
                <div class="card shadow-sm bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <h1 class="display-5 mb-3">{{ $listing->title }}</h1>
                    <div class="price-container my-3">
                        <h3 class="text-2xl font-bold">
                            {{ $listing->currency === 'EUR' ? '€' : '$' }}{{ $listing->price }} {{ $listing->currency }}
                        </h3>

                        <span class="text-sm text-success font-semibold">
                            {{ __('messages.show.approx', ['price' => $converted['price'], 'currency' => ($converted['currency'] === 'EUR' ? '€' : '$') . ' ' . $converted['currency']]) }}
                        </span>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="mb-0">
                            <label class="form-label"><strong>{{ __('messages.show.availability') }}</strong></label>
                            <p class="form-control-plaintext">
                                {{ $listing->status }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>{{ __('messages.show.category') }}</strong></label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-secondary">{{ $listing->category->name ?? __('messages.show.uncategorized') }}</span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>{{ __('messages.show.posted_by') }}</strong></label>
                            <p class="form-control-plaintext">
                                <i class="bi bi-person-circle"></i> {{ $listing->user->name }}
                            </p>
                        </div>

                        <div class="mb-0">
                            <label class="form-label"><strong>{{ __('messages.show.listed_on') }}</strong></label>
                            <p class="form-control-plaintext">
                                {{ $listing->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ __('messages.show.description') }}</h5>
                        <p class="card-text">{{ $listing->description }}</p>
                    </div>
                </div>

                @auth
                <div class="mb-4">
                    @can('update', $listing)
                    <a href="{{ route('listing.edit', $listing) }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-pencil-square"></i> {{ __('messages.show.edit_btn') }}
                    </a>
                    @endcan

                    @can('delete', $listing)
                    <form action="{{ route('listing.destroy', $listing) }}"
                        method="POST"
                        data-confirm-message="{{ __('messages.show.delete_confirm') }}"
                        onsubmit="return confirm(this.getAttribute('data-confirm-message'));"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg me-2">
                            <i class="bi bi-trash"></i> {{ __('messages.show.delete_btn') }}
                        </button>
                    </form>
                    @endcan
                    @can('markSold', $listing)
                    @if($listing->status === 'active')

                    <form action="{{ route('listing.markAsSold', $listing->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-lg">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ __('messages.show.mark_sold_btn') }}
                        </button>
                    </form>
                    @endif
                    @endcan
                </div>
                @endauth


                @if(!Auth::check() || Auth::user()->id !== $listing->user_id)
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        @auth
                        <h5 class="card-title mb-3">
                            <i class="bi bi-chat-dots"></i> {{ __('messages.show.interested_title') }}
                        </h5>

                        <form action="{{ route('message.sendFromListing', $listing) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea
                                    name="content"
                                    class="form-control"
                                    rows="3"
                                    placeholder="{{ __('messages.show.msg_placeholder') }}"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-send"></i> {{ __('messages.show.send_msg_btn') }}
                            </button>
                        </form>
                        @else
                        <h5 class="card-title mb-3">{{ __('messages.show.contact_title') }}</h5>
                        <p class="card-text mb-3">{{ __('messages.show.login_required') }}</p>
                        <a href="{{ route('auth.login') }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('messages.show.login_btn') }}
                        </a>
                        @endauth
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> {{ __('messages.show.own_listing') }}
                </div>
                @endif

            </div>
        </div>

        @if($listing->category)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">{{ __('messages.show.more_in', ['category' => $listing->category->name]) }}</h3>
            </div>

            @forelse($listing->category->listings()->where('id', '!=', $listing->id)->limit(4)->get() as $related)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div style="overflow: hidden; height: 200px;">
                        @if($related->images->count() > 0)
                        <img
                            src="{{ asset('storage/' . $related->images->first()->image_path) }}"
                            alt="{{ $related->title }}"
                            class="img-fluid w-100 h-100"
                            style="object-fit: cover;">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title text-truncate">{{ $related->title }}</h6>
                        <p class="text-primary fw-bold">${{ number_format($related->price, 2) }}</p>
                        <a href="{{ route('listing.show', $related) }}" class="btn btn-sm btn-outline-primary">
                            {{ __('messages.show.view_btn') }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        @endif
    </div>
</x-layout>
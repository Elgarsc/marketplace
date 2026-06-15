<x-layout>
    <div class="container mt-5">
        <div class="mb-4">
            <a href="{{ route('listing.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Listings
            </a>
        </div>

        <div class="row">
            <!-- Images Section -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body p-0">
                        @if($listing->images->count() > 0)
                        <img
                            src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                            alt="{{ $listing->title }}"
                            class="img-fluid w-100"
                            style="max-height: 500px; object-fit: cover;">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                            <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail Gallery -->
                @if($listing->images->count() > 1)
                <div class="d-flex gap-2 overflow-auto pb-2">
                    @foreach($listing->images as $image)
                    <img
                        src="{{ asset('storage/' . $image->image_path) }}"
                        alt="Thumbnail"
                        class="img-thumbnail"
                        style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="col-md-6">
                <!-- Title and Price -->
                <div class="mb-4">
                    <h1 class="display-5 mb-3">{{ $listing->title }}</h1>
                    <p class="fs-4 text-primary fw-bold mb-3">
                        ${{ number_format($listing->price, 2) }}
                    </p>
                </div>

                <!-- Listing Info Card -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label"><strong>Category</strong></label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-secondary">{{ $listing->category->name ?? 'Uncategorized' }}</span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Posted by</strong></label>
                            <p class="form-control-plaintext">
                                <i class="bi bi-person-circle"></i> {{ $listing->user->name }}
                            </p>
                        </div>

                        <div class="mb-0">
                            <label class="form-label"><strong>Listed On</strong></label>
                            <p class="form-control-plaintext">
                                {{ $listing->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Description</h5>
                        <p class="card-text">{{ $listing->description }}</p>
                    </div>
                </div>

                <!-- Buttons -->
                @auth
                <div class="mb-4">
                    @can('update', $listing)
                    <a href="{{ route('listing.edit', $listing) }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-pencil-square"></i> Edit Listing
                    </a>
                    @endcan

                    @can('delete', $listing)
                    <form action="{{ route('listing.destroy', $listing) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg me-2">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                    @endcan
                    @can('markSold', $listing)
                    @if($listing->status === 'active')

                    <form action="{{ route('listing.markAsSold', $listing->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-lg">
                            <i class="bi bi-check-circle-fill me-2"></i> Mark as Sold
                        </button>
                    </form>
                    @endif
                    @endcan
                </div>
                @endauth


                <!-- Contact Seller Section -->
                @if(!Auth::check() || Auth::user()->id !== $listing->user_id)
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        @auth
                        <h5 class="card-title mb-3">
                            <i class="bi bi-chat-dots"></i> Interested in this item?
                        </h5>

                        <form action="{{ route('message.sendFromListing', $listing) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea
                                    name="content"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Send a message to the seller..."
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-send"></i> Send Message
                            </button>
                        </form>
                        @else
                        <h5 class="card-title mb-3">Want to contact the seller?</h5>
                        <p class="card-text mb-3">You need to be logged in to send messages.</p>
                        <a href="{{ route('auth.login') }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Login to Message
                        </a>
                        @endauth
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> This is your listing
                </div>
                @endif

            </div>
        </div>

        <!-- Related Listings -->
        @if($listing->category)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">More in {{ $listing->category->name }}</h3>
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
                            View
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
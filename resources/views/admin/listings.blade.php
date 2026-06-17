<x-layout>
    <div class="container-fluid mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-5 mb-2">
                            <i class="bi bi-shop"></i> {{ __('messages.moderate.title') }}
                        </h1>
                        <p class="text-muted">{{ __('messages.moderate.sub') }}</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> {{ __('messages.moderate.back_btn') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if($listings->count() > 0)
                <div class="row">
                    @foreach($listings as $listing)
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="row g-0 h-100">
                                <div class="col-md-4" style="max-height: 250px; overflow: hidden;">
                                    @if($listing->images->count() > 0)
                                    <img
                                        src="{{ asset('storage/' . $listing->images->first()->image_path) }}"
                                        alt="{{ $listing->title }}"
                                        class="img-fluid w-100 h-100"
                                        style="object-fit: cover;">
                                    @else
                                    <div class="bg-light d-flex align-items-center justify-content-center w-100 h-100">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                    @endif
                                </div>

                                <div class="col-md-8">
                                    <div class="card-body d-flex flex-column h-100">
                                        <div>
                                            <h6 class="card-title">
                                                <a href="{{ route('listing.show', $listing) }}" target="_blank" class="text-decoration-none">
                                                    {{ $listing->title }}
                                                </a>
                                            </h6>

                                            <p class="text-primary fw-bold mb-2">
                                                ${{ number_format($listing->price, 2) }}
                                            </p>

                                            <p class="text-muted small mb-2">
                                                <strong>{{ __('messages.moderate.category') }}</strong> {{ $listing->category->name ?? 'N/A' }}
                                            </p>

                                            <p class="text-muted small mb-2">
                                                <strong>{{ __('messages.moderate.seller') }}</strong>
                                                <a href="mailto:{{ $listing->user->email }}">{{ $listing->user->name }}</a>
                                            </p>

                                            <p class="card-text small text-muted mb-3" style="max-height: 60px; overflow: hidden;">
                                                {{ Str::limit($listing->description, 120) }}
                                            </p>

                                            <p class="text-muted small mb-0">
                                                <strong>{{ __('messages.moderate.posted') }}</strong> {{ $listing->created_at->format('M d, Y H:i') }}
                                            </p>
                                        </div>

                                        <div class="mt-3 pt-3 border-top">
                                            <div class="btn-group w-100" role="group">
                                                <a
                                                    href="{{ route('listing.show', $listing) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> {{ __('messages.moderate.view') }}
                                                </a>
                                                <form action="{{ route('admin.deleteListing', $listing) }}"
                                                    method="POST"
                                                    class="flex-grow-1"
                                                    data-confirm-message="{{ __('messages.moderate.delete_confirm') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger w-100"
                                                        onclick="return confirm(this.closest('form').getAttribute('data-confirm-message'))">
                                                        <i class="bi bi-trash"></i> {{ __('messages.moderate.delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $listings->links() }}
                    </div>
                </div>
                @else
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 mb-2">{{ __('messages.moderate.all_clear') }}</h5>
                        <p class="text-muted mb-0">{{ __('messages.moderate.no_listings') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
<x-layout>
    <div class="mt-5">
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="display-4 mb-2">
                    <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard.title') }}
                </h1>
                <p class="text-muted">{{ __('messages.dashboard.sub') }}</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">{{ __('messages.dashboard.total_users') }}</h6>
                                <h3 class="mb-0 text-primary fw-bold">{{ $totalUsers }}</h3>
                            </div>
                            <i class="bi bi-people-fill text-primary fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">{{ __('messages.dashboard.total_listings') }}</h6>
                                <h3 class="mb-0 text-success fw-bold">{{ $totalListings }}</h3>
                            </div>
                            <i class="bi bi-shop text-success fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">{{ __('messages.dashboard.categories') }}</h6>
                                <h3 class="mb-0 text-info fw-bold">{{ $totalCategories }}</h3>
                            </div>
                            <i class="bi bi-tag-fill text-info fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">{{ __('messages.dashboard.quick_links') }}</h6>
                                <p class="mb-0 small mt-2">
                                    <a href="{{ route('admin.users') }}" class="text-decoration-none fw-medium">{{ __('messages.dashboard.view_users') }}</a>
                                    <span class="text-muted mx-1">|</span>
                                    <a href="{{ route('admin.listings') }}" class="text-decoration-none fw-medium">{{ __('messages.dashboard.view_listings') }}</a>
                                </p>
                            </div>
                            <i class="bi bi-gear-fill text-secondary fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light p-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ __('messages.dashboard.recent_users') }}</h6>
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">{{ __('messages.dashboard.view_all') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.dashboard.th_name') }}</th>
                                        <th>{{ __('messages.dashboard.th_email') }}</th>
                                        <th>{{ __('messages.dashboard.th_role') }}</th>
                                        <th>{{ __('messages.dashboard.th_joined') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>
                                            <small>{{ $user->email }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $user->created_at->format('M d') }}</small>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">{{ __('messages.dashboard.no_users') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light p-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ __('messages.dashboard.recent_listings') }}</h6>
                        <a href="{{ route('admin.listings') }}" class="btn btn-sm btn-outline-primary">{{ __('messages.dashboard.view_all') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.dashboard.th_title') }}</th>
                                        <th>{{ __('messages.dashboard.th_price') }}</th>
                                        <th>{{ __('messages.dashboard.th_category') }}</th>
                                        <th>{{ __('messages.dashboard.th_posted_by') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentListings as $listing)
                                    <tr>
                                        <td>
                                            <strong>{{ Str::limit($listing->title, 20) }}</strong>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($listing->price, 2) }}</strong>
                                        </td>
                                        <td>
                                            <small>{{ $listing->category->name ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $listing->user->name }}</small>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">{{ __('messages.dashboard.no_listings') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light p-3">
                        <h6 class="mb-0">{{ __('messages.dashboard.admin_actions') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                                <i class="bi bi-people"></i> {{ __('messages.dashboard.manage_users') }}
                            </a>
                            <a href="{{ route('admin.listings') }}" class="btn btn-outline-primary">
                                <i class="bi bi-shop"></i> {{ __('messages.dashboard.moderate_listings') }}
                            </a>
                            <a href="{{ route('admin.audit_logs') }}" class="btn btn-outline-primary">
                                <i class="bi bi-shop"></i> {{ __('messages.dashboard.view_logs') }}
                            </a>
                            <a href="{{ route('admin.createOrDeleteCategory') }}" class="btn btn-outline-primary">
                                <i></i> {{ __('messages.dashboard.manage_categories') }}
                            </a>
                            <a href="{{ route('listing.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> {{ __('messages.dashboard.back_to_marketplace') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
<x-layout>
    <div class="mt-5">
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="display-4 mb-2">
                    <i class="bi bi-speedometer2"></i> Admin Dashboard
                </h1>
                <p class="text-muted">Manage users, listings, and categories</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">Total Users</h6>
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
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">Total Listings</h6>
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
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">Categories</h6>
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
                                <h6 class="text-muted small text-uppercase fw-semibold mb-1">Quick Links</h6>
                                <p class="mb-0 small mt-2">
                                    <a href="{{ route('admin.users') }}" class="text-decoration-none fw-medium">View Users</a>
                                    <span class="text-muted mx-1">|</span>
                                    <a href="{{ route('admin.listings') }}" class="text-decoration-none fw-medium">View Listings</a>
                                </p>
                            </div>
                            <i class="bi bi-gear-fill text-secondary fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <!-- Recent Users -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light p-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Users</h6>
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
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
                                        <td colspan="4" class="text-center py-3">No users yet</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Listings -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light p-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Listings</h6>
                        <a href="{{ route('admin.listings') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Posted by</th>
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
                                        <td colspan="4" class="text-center py-3">No listings yet</td>
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
                        <h6 class="mb-0">Admin Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                                <i class="bi bi-people"></i> Manage Users
                            </a>
                            <a href="{{ route('admin.listings') }}" class="btn btn-outline-primary">
                                <i class="bi bi-shop"></i> Moderate Listings
                            </a>
                            <a href="{{ route('admin.audit_logs') }}" class="btn btn-outline-primary">
                                <i class="bi bi-shop"></i> View Logs
                            </a>
                            <a href="{{ route('listing.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Marketplace
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
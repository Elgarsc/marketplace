<x-layout>
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="mb-0 font-weight-bold">Manage Categories</h5>
            </div>
            <div class="card-body p-4">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('admin.createCategory') }}" method="POST" class="row g-3 align-items-end mb-4">
                    @csrf

                    <div class="col-md-4">
                        <label for="name" class="form-label font-weight-bold mb-1">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}" placeholder="e.g., Electronics">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="description" class="form-label font-weight-bold mb-1">Description (Optional)</label>
                        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="Brief description of the category...">
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 font-weight-bold">
                            Add Category
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                @if($categories->isEmpty())
                <div class="text-center my-4">
                    <p class="text-muted mb-0">No categories created yet.</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 30%">Name</th>
                                <th style="width: 55%">Description</th>
                                <th style="width: 15%" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td><strong class="text-dark">{{ $category->name }}</strong></td>
                                <td><span class="text-muted small">{{ $category->description ?? 'No description provided.' }}</span></td>
                                <td class="text-end">
                                    <form action="{{ route('admin.deleteCategory', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete &quot;{{ $category->name }}&quot;?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-layout>
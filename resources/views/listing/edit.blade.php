<x-layout>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <a href="{{ route('listing.show', $listing) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Listing
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h1 class="card-title mb-4">
                            <i class="bi bi-pencil-square"></i> Edit Listing
                        </h1>

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form action="{{ route('listing.update', $listing) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label"><strong>Item Title *</strong></label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Enter item title"
                                    value="{{ old('title', $listing->title) }}"
                                    required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label"><strong>Description *</strong></label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    rows="5"
                                    placeholder="Describe your item in detail..."
                                    required>{{ old('description', $listing->description) }}</textarea>
                                <small class="text-muted">Max 1000 characters</small>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="mb-4">
                                <label for="price" class="form-label"><strong>Price & Currency *</strong></label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Enter price"
                                        step="0.01"
                                        min="0"
                                        value="{{ old('price', $listing->price) }}"
                                        required>

                                    <select name="currency" class="form-select @error('currency') is-invalid @enderror" style="max-width: 100px;" required>
                                        <option value="EUR" {{ old('currency', $listing->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                        <option value="USD" {{ old('currency', $listing->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    </select>
                                </div>

                                @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @error('currency')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label for="category_id" class="form-label"><strong>Category *</strong></label>
                                <select
                                    id="category_id"
                                    name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select a Category --</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Images -->
                            @if($listing->images->count() > 0)
                            <div class="mb-4">
                                <label class="form-label"><strong>Current Images</strong></label>
                                <div class="row">
                                    @foreach($listing->images as $image)
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            <img
                                                src="{{ asset('storage/' . $image->image_path) }}"
                                                alt="Listing image"
                                                class="card-img-top"
                                                style="height: 150px; object-fit: cover;">
                                            <div class="card-body p-2">
                                                <small class="text-muted">Uploaded: {{ $image->created_at->format('M d') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <hr>
                            </div>
                            @endif

                            <!-- Add New Images -->
                            <div class="mb-4">
                                <label for="images" class="form-label"><strong>Add New Images</strong></label>
                                <div class="form-control border-dashed p-4 text-center" id="dropArea" style="border: 2px dashed #ccc; cursor: pointer;">
                                    <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #999;"></i>
                                    <p class="mt-3 mb-0">
                                        <strong>Drag & Drop Images Here or <u>Browse</u></strong>
                                    </p>
                                    <small class="text-muted">Supported formats: JPEG, PNG, GIF (Max 2MB each)</small>
                                    <input
                                        type="file"
                                        id="images"
                                        name="images[]"
                                        class="form-control d-none"
                                        multiple
                                        accept="image/*">
                                </div>
                                <div id="imagePreview" class="mt-3"></div>
                                @error('images')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                                @error('images.*')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Save Changes
                                </button>
                                <a href="{{ route('listing.show', $listing) }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('dropArea');
            const imageInput = document.getElementById('images');
            const imagePreview = document.getElementById('imagePreview');

            // Click to browse
            dropArea.addEventListener('click', () => imageInput.click());

            // Drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropArea.style.backgroundColor = '#e9ecef';
            }

            function unhighlight(e) {
                dropArea.style.backgroundColor = 'transparent';
            }

            dropArea.addEventListener('drop', handleDrop, false);
            imageInput.addEventListener('change', handleFiles, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                imageInput.files = files;
                handleFiles({
                    target: {
                        files: files
                    }
                });
            }

            function handleFiles(e) {
                const files = e.target.files;
                imagePreview.innerHTML = '';

                if (files.length > 0) {
                    const preview = document.createElement('div');
                    preview.className = 'row mt-3';

                    Array.from(files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const col = document.createElement('div');
                            col.className = 'col-md-3 mb-3';
                            col.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" alt="Preview">
                            <div class="card-body p-2">
                                <small class="text-truncate">${file.name}</small>
                            </div>
                        </div>
                    `;
                            preview.appendChild(col);
                        };
                        reader.readAsDataURL(file);
                    });
                    imagePreview.appendChild(preview);
                }
            }
        });
    </script>
</x-layout>
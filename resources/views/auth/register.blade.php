<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h1 class="card-title mb-4 text-center">{{ __('messages.auth.register') }}</h1>

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form action="{{ route('auth.register') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label"><strong>{{ __('messages.auth.name') }}</strong></label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="{{ __('messages.auth.name_placeholder') }}"
                                    value="{{ old('name') }}"
                                    required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label"><strong>{{ __('messages.auth.email') }}</strong></label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="{{ __('messages.auth.email_placeholder') }}"
                                    value="{{ old('email') }}"
                                    required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label"><strong>{{ __('messages.auth.account_type') }}</strong></label>
                                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">{{ __('messages.auth.select_account_type') }}</option>
                                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>{{ __('messages.auth.role_user') }}</option>
                                    <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>{{ __('messages.auth.role_seller') }}</option>
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label"><strong>{{ __('messages.auth.password') }}</strong></label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ __('messages.auth.password_min_placeholder') }}"
                                    required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label"><strong>{{ __('messages.auth.confirm_password') }}</strong></label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="{{ __('messages.auth.confirm_password_placeholder') }}"
                                    required>
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                                <i class="bi bi-person-plus"></i> {{ __('messages.auth.register') }}
                            </button>
                        </form>

                        <p class="text-center text-muted mb-0">
                            {{ __('messages.auth.already_have_account') }}
                            <a href="{{ route('auth.login') }}" class="text-decoration-none">{{ __('messages.auth.login_here') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
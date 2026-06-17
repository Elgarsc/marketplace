<x-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h1 class="card-title mb-4 text-center">{{ __('messages.auth.login') }}</h1>

                        <form action="{{ route('auth.login') }}" method="POST">
                            @csrf

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

                            <div class="mb-4">
                                <label for="password" class="form-label"><strong>{{ __('messages.auth.password') }}</strong></label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ __('messages.auth.password_placeholder') }}"
                                    required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg mb-3">
                                <i class="bi bi-box-arrow-in-right"></i> {{ __('messages.auth.login') }}
                            </button>
                        </form>

                        <p class="text-center text-muted mb-0">
                            {{ __('messages.auth.no_account') }}
                            <a href="{{ route('auth.register') }}" class="text-decoration-none">{{ __('messages.auth.register_here') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('messages.global.app_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            margin-left: 0.5rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .footer {
            background-color: #343a40;
            color: white;
            margin-top: 4rem;
            padding: 2rem 0;
        }

        .listing-image {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        .container {
            max-width: 1200px;
        }
    </style>
</head>

<body>
    <x-navbar />

    <div class="container mt-4">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ __('messages.alerts.error') }}</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>

    <div class="container mb-5">
        {{ $slot }}
    </div>

    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>{{ __('messages.footer.about_us') }}</h5>
                    <p>{{ __('messages.footer.about_us_desc') }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>{{ __('messages.footer.contact') }}</h5>
                    <p class="mb-0">Email: info@marketplace.com</p>
                    <p>Phone: +371 12 345 678</p>
                </div>
            </div>
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ __('messages.global.app_name') }}. {{ __('messages.footer.rights') }}</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
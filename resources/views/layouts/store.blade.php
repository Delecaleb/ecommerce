<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Test Commerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light py-3">
            <div class="container">
                <a class="navbar-brand" href="/">MART</a>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        @auth

                            @if (Auth::user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('product.index') }}">Admin
                                        Dashboard </a>
                                </li>
                            @endif

                        @endauth
                    </ul>
                    <form class="d-flex" action="{{ route('home') }}" method="get">
                        @csrf
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                            name="search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                @guest
                    <ul class="navbar-nav ms-5 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="btn btn-outline-primary px-4 py-2" aria-current="page"
                                href="{{ route('login') }}">Login</a>
                        </li>
                    </ul>
                @endguest
                @auth
                    <div class="d-flex">
                        <a class="btn px-4 py-2" aria-current="page" href="{{ route('cart.show') }}">
                            <i class="bi bi-cart3"></i>
                        </a>

                        <a class="btn px-4 py-2" aria-current="page" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i>
                        </a>
                    </div>
                @endauth

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <div class="container">
                {{ $slot }}
            </div>
        </main>
    </div>
    <footer class="bg-light">
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>

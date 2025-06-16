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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>


<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
            <div class="container">
                <a class="navbar-brand" href="/">MART</a>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>

                    </ul>
                </div>

                @auth
                    <div class="d-flex">
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
                <div class="row">
                    <div class="col-md-2">
                        <div class="card rounded-lg mt-5">
                            <div class="sideNav">
                                <a class="{{ request()->is('product') ? 'activeSideMenu' : '' }}"
                                    href="{{ route('product.index') }}">Products</a>
                                <a class="{{ request()->is('cart-item-list') ? 'activeSideMenu' : '' }}"
                                    href="{{ route('cart.list') }}">Cart</a>
                                <a class="{{ request()->is('order-list') ? 'activeSideMenu' : '' }}"
                                    href="{{ route('order.list') }}">Oders</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class=" py-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>

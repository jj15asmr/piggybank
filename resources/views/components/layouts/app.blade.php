<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Piggybank &bull; Porkbun Domain Costs Calculator</title>

    {{-- Meta Tags --}}
    <meta name="title" content="Piggybank &bull; Porkbun Domain Costs Calculator">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Jacob Prunkl">
    <meta name="theme-color" content="#f49090">

    {{-- Favicons --}}
    <link rel="icon" type="image/png" href="{{ asset('img/favicons/32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicons/16x16.png') }}" sizes="16x16" />

    {{-- Bootstrap 5.2.3 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    {{-- Bunny Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=open-sans:300,400,700" rel="stylesheet" />

    {{-- FontAwesome 6.4.0 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Animate.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    {{-- Livewire CSS --}}
    <livewire:styles />
</head>
<body class="d-flex flex-column min-vh-100">
    <div id="top-bar"></div>

    <div class="container">
        {{-- Logo --}}
        <a id="logo" href="#">
            <img class="img-fluid d-block mx-auto my-5" src="{{ asset('img/logo.svg') }}" width="460">
        </a>

        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-4">
                        {{-- Main Content --}}
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div id="footer" class="mt-auto">
        <div class="container">
            <div class="d-none d-md-block">
                <span class="float-start">Created by JJ15 &middot; <a class="text-decoration-none" href="https://github.com/jj15asmr/piggybank">View the Source Code <i class="fa-brands fa-github"></i></a></span>
                <span class="text-muted float-end">Not Affiliated with Porkbun LLC</span>
            </div>

            <div class="text-center d-block d-md-none">
                <p class="mb-1">Created by JJ15 &middot; <a class="text-decoration-none" href="https://github.com/jj15asmr/piggybank">View the Source Code <i class="fa-brands fa-github"></i></a></p>
                <p class="text-muted mb-0">Not Affiliated with Porkbun LLC</p>
            </div>
        </div>
    </div>

    {{-- Bootstrap 5.2.3 JS w/ Popper.js --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    {{-- Livewire JS --}}
    <livewire:scripts />

    {{-- Custom JS --}}
    <script>
        const logo_sound = new Audio('{{ asset('oink.mp3') }}');
    </script>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
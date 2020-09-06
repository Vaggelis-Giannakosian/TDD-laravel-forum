<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Trix Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.4/trix.min.css" />

    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!}
    </script>

    <style>
        body {
            padding-bottom: 100px;
        }

        .level{
            display: flex;
            align-items: center;
        }

        .flex{
            flex: 1;
        }

        [v-cloak]{
            display: none;
        }
    </style>

    @yield('css')

</head>
<body>
<div id="app">

    @include('layouts.nav')

    <main class="py-4">
        @yield('content')
    </main>

    <flash message="{{ session('flash') }}"></flash>
</div>
</body>
</html>

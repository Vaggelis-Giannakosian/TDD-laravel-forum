<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
        .h-500{
            height: 500px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content" id="app">


        <div class="title m-b-md">
            Laravel
        </div>


        <div class="links mb-5">
            <scroll-link selector="#categories" >Testimonials</scroll-link>
            <a href="https://laracasts.com">Laracasts</a>
            <a href="https://laravel-news.com">News</a>
            <a href="https://blog.laravel.com">Blog</a>
            <a href="https://nova.laravel.com">Nova</a>
            <a href="https://forge.laravel.com">Forge</a>
            <a href="https://vapor.laravel.com">Vapor</a>
            <a href="https://github.com/laravel/laravel">GitHub</a>
        </div>


        <div class="h-500"></div>

        <dropdown class="d-inline-block">

            <template v-slot:trigger>
                <button>...</button>
            </template>

            <li class=""  v-scroll-to="'#app'"><a @click.prevent="" class="text-info dropdown-item text-sm-left" v-scroll-to="'#app'" href="#">Edit</a></li>
            <li class=""><a class="text-info dropdown-item text-sm-left " href="#">Delete</a></li>
            <li class=""><a class="text-info  dropdown-item text-sm-left " href="#">Report</a></li>

        </dropdown>


        <div class="m-5"> </div>

        <dropdown class="d-inline-block">

            <template v-slot:trigger>
                <button>Click me for more options</button>
            </template>

            <li class=""  v-scroll-to="'#app'"><a @click.prevent="" class="text-info dropdown-item text-sm-left" v-scroll-to="'#app'" href="#">Edit</a></li>
            <li class=""><a class="text-info dropdown-item text-sm-left " href="#">Delete</a></li>
            <li class=""><a class="text-info  dropdown-item text-sm-left " href="#">Report</a></li>

        </dropdown>


        <div class="h-500"></div>


        <div id="categories" class="mb-5 mt-5">
            <h3 class="text-left">Categories</h3>
            <div style="height: 100px" class="d-flex justify-content-between align-items-center">

                <scroll-link class="w-25 bg-dark m-1 d-block text-white " selector="#app" >Item</scroll-link>
                <div class="w-25 bg-dark m-1  text-white" v-scroll-to="'#app'">Item</div>
                <div class="w-25 bg-dark  m-1 text-white">Item</div>
                <div class="w-25 bg-dark  m-1 text-white">Item</div>
            </div>
        </div>

    </div>

</div>

<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>


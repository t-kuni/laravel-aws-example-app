<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" rel="stylesheet"></script>

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

            .full-height {
                height: 100vh;
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
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel v2
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>

                <p>
                    {{$item->name}}
                </p>

                <form method="POST" action="{{ action('TopController@post') }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input type="text" name="name" value="{{$item->name}}" />
                    <button type="submit">更新</button>
                </form>

                <div>
                    Elapsed Time: {{$item->elapsed_time}} minute.
                </div>

                <div>
                    <img src="{{asset('storage/' . $item->image)}}" style="width: 200px;"/>
                </div>

                <form method="POST" action="{{ action('TopController@uploadImage') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input type="file" name="file" />
                    <button type="submit">送信</button>
                </form>

                <div class="text">
                    この文字が赤色になっていればフロントのビルド成功
                </div>

                <div>
                    <a href="chat">Chat(WebSocketサンプル)</a>
                </div>

                <div>
                    <a href="users">ユーザ一覧</a>
                </div>

                <div>
                    <a href="subscription">Laravel-Cachierサンプル</a>
                </div>

                <div>
                    <div>キャッシュ： {{$cache}}</div>
                </div>
                <form method="POST" action="{{ action('TopController@saveCache') }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input type="text" name="cache"/>
                    <button type="submit">キャッシュ保存</button>
                </form>
                <form method="POST" action="{{ action('TopController@clearCache') }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <button type="submit">キャッシュクリア</button>
                </form>
            </div>
        </div>
    </body>
</html>

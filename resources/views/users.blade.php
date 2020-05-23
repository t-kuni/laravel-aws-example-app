<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

{{--        <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
{{--        <script src="{{ asset('js/app.js') }}" rel="stylesheet"></script>--}}
    </head>
    <body>
        <p style="color: red">
            {{ session('message') }}
        </p>
        <h1>ユーザ作成</h1>
        <div>
            <form method="POST" action="/users/create">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <div>
                    名前<input type="name" name="name">
                </div>
                <div>
                    email<input type="email" name="email">
                </div>
                <div>
                    <button type="submit">送信</button>
                </div>
            </form>
        </div>
        @foreach ($users as $user)
            <div>
                <a href="/users/{{$user->id}}">{{$user->name}}</a>
            </div>
        @endforeach
    </body>
</html>

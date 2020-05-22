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
        <p>定期購入</p>
        <div>
            <form method="POST" action="/subscription/buy">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <input type="text" name="body">
                <button type="button" onclick="onClickSendMessage()">送信</button>
            </form>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script src="https://js.stripe.com/v3/"></script>

{{--        <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
{{--        <script src="{{ asset('js/app.js') }}" rel="stylesheet"></script>--}}
    </head>
    <body>
        <p style="color: red">
            {{ session('message') }}
        </p>

        <h1>ユーザ情報</h1>
        <pre>顧客ID: {{ $stripeCustomer->id }}</pre>
        <pre>カード情報: {{ $paymentMethods[0]->id ?? null}}</pre>
        <pre>サブスク:
            @foreach($plansSubscribed as $plan)
                {{$plan['title']}},
            @endforeach
        </pre>

        <h1>カードの登録</h1>
        <div>
            <form id="card-form" method="POST" action="/users/{{$user->id}}/cards/create">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <input type="hidden" name="payment_method" />

                Card Holder Name<input id="card-holder-name" type="text">

                <!-- Stripe Elements Placeholder -->
                <div id="card-element" style="width: 300px"></div>

                <button type="button" id="card-button" data-secret="{{ $intent->client_secret }}">
                    保存
                </button>
            </form>
        </div>

        <h1>定期購入</h1>
        <div>
            @if ($plansSubscribed->isEmpty())
                <form method="POST" action="/users/{{$user->id}}/subscriptions/buy">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />

                    <div>
                        <select name="plan_id">
                            @foreach ($plansNotSubscribed as $plan)
                                <option value="{{$plan['id']}}">{{$plan['title']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        個数<input type="number" name="amount" value="1" />
                    </div>

                    <div>
                        試用期間<input type="number" name="trial_days" value="0"/>
                    </div>

                    <div>
                        クーポン<input type="text" name="coupon" value=""/>
                    </div>

                    <div>
                        <button type="submit">
                            購入
                        </button>
                    </div>
                </form>
            @else
                <p>契約済み</p>
            @endif
        </div>

        <h1>プラン変更</h1>
        <div>
            @if (!$plansSubscribed->isEmpty())
                <form method="POST" action="/users/{{$user->id}}/subscriptions/swap">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />

                    <select name="plan_id">
                        @foreach ($plansNotSubscribed as $plan)
                            <option value="{{$plan['id']}}">{{$plan['title']}}</option>
                        @endforeach
                    </select>

                    <button type="submit">
                        購入
                    </button>
                </form>
            @else
                <p>契約無し</p>
            @endif
        </div>

        <h1>定期購入解約</h1>
        <div>
            @if (!$plansSubscribed->isEmpty())
                <form method="POST" action="/users/{{$user->id}}/subscriptions/cancel">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />

                    <button type="submit">
                        解約
                    </button>
                </form>

                <form method="POST" action="/users/{{$user->id}}/subscriptions/force-cancel">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />

                    <button type="submit">
                        強制解約
                    </button>
                </form>
            @else
                <p>契約無し</p>
            @endif
        </div>

        <script>
            const stripe = Stripe('pk_test_wiW8iwXGdMRMqbqzzJcw0JQ300IbZKisk3');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardForm = document.getElementById('card-form');
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const paymentMethodInput = document.querySelector('input[name=payment_method]');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                } else {
                    paymentMethodInput.value = setupIntent.payment_method;
                    cardForm.submit();
                }
            });
        </script>
    </body>
</html>

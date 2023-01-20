@extends('layouts.app')

@section('content')

    <main class="sm:container sm:mx-auto sm:mt-10">
        <div class="w-full sm:px-6">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                    Coin Market
                </header>

                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li class="text-green-600">{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif

                @foreach($account as $number)
                    <p>Crypto account money: {{ number_format($number->balance / 100, 2) }}{{ $number->currencySymbol }}</p>
                @endforeach
                <div class="w-full p-6">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3">Symbol</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Percent change 1h</th>
                            <th scope="col" class="px-6 py-3">Percent change 24h</th>
                            <th scope="col" class="px-6 py-3">Percent change 7d</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cryptoCurrencies as $coin)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <form method="POST">
                                    @csrf
                                    <input type="hidden" id="symbol" name="symbol" value="{{ $coin->symbol }}">
                                    <input type="hidden" id="buyPrice" name="buyPrice" value="{{ $coin->price }}">

                                    <td><img src="https://coinicons-api.vercel.app/api/icon/{{ strtolower($coin->symbol) }}" alt="{{ $coin->symbol }} icon" width="30" height="30"></td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $coin->symbol }}</td>
                                    <td class="px-6 py-4">{{ $coin->name }}</td>
                                    <td class="px-6 py-4">{{ number_format($coin->price, 2)}}</td>
                                    <td class="px-6 py-4 {{ $coin->percentChange1h > 0 ? 'text-green-500' : 'text-red-700'}}">
                                    {{ number_format($coin->percentChange1h, 2) }}
                                    </td>
                                    <td class="px-6 py-4 {{ $coin->percentChange24h > 0 ? 'text-green-500' : 'text-red-700'}}">
                                    {{ number_format($coin->percentChange24h, 2) }}
                                    </td>
                                    <td class="px-6 py-4 {{ $coin->percentChange7d > 0 ? 'text-green-500' : 'text-red-700'}}">
                                    {{ number_format($coin->percentChange7d, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <input id="amount" name="amount" type="number" step=".01"
                                               class="block p-1 pl-0.5 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-20">
                                        <br>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button type="submit" formaction="/buyCoin"class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                            {{ __('Buy') }}
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </section>

                <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                    <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                        Coin Wallet
                    </header>

                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <ul>
                                <li class="text-green-600">{!! \Session::get('success') !!}</li>
                            </ul>
                        </div>
                    @endif

                    @foreach($account as $number)
                        <p>Crypto account money: {{ number_format($number->balance / 100, 2) }}{{ $number->currencySymbol }}</p>
                    @endforeach
                    <div class="w-full p-6">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3"></th>
                                <th scope="col" class="px-6 py-3">Symbol</th>
                                <th scope="col" class="px-6 py-3">Amount</th>
                                <th scope="col" class="px-6 py-3">Buy price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($wallet as $stock)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <form method="POST">
                                        @csrf
                                        <input type="hidden" id="symbol" name="symbol" value="{{ $stock->symbol }}">
                                        <input type="hidden" id="buyPrice" name="buyPrice" value="{{ $stock->buy_price }}">

                                        <td><img src="https://coinicons-api.vercel.app/api/icon/{{ strtolower($stock->symbol) }}" alt="{{ $stock->symbol }} icon" width="30" height="30"></td>
                                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $stock->symbol }}</td>
                                        <td class="px-6 py-4">{{ $stock->amount }}</td>
                                        <td class="px-6 py-4">{{ $stock->buy_price }}</td>
                                        <td class="px-6 py-4">
                                            <input id="amountSell" name="amountSell" type="number" step=".01"
                                                   class="block p-1 pl-0.5 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-20">
                                            <br>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="submit" formaction="/sellCoin"class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                {{ __('Sell') }}
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </section>
        </div>
    </main>
@endsection

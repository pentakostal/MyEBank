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
                                        <input id="coinAmount" name="coinAmount" type="text"
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
        </div>
    </main>
@endsection

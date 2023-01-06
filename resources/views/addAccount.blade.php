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
                    Create New Account
                </header>

                <form method="POST">
                    @csrf
                    <div>
                        <label for="currency">{{ __('Choose currency') }}:</label>
                            <select name = "currency" id="currency">
                                <option value = "EUR">EUR</option>
                                <option value = "USD">USD</option>
                                <option value = "JPY">JPY</option>
                                <option value = "CNY">CNY</option>
                                <option value = "BRL">BRL</option>
                            </select>
                    </div>

                    <br>
                    <label for="status">{{ __('Choose debit ore credit') }}:</label>
                        <select name = "status" id="status">
                            <option value = "debit">Debit</option>
                            <option value = "credit">Credit</option>
                        </select>
                    <br>
                    <br>
                    <div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            {{ __('Create Account') }}
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection

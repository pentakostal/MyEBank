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
                    Payment
                </header>

                <div class="w-full p-6">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        </thead>
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li class="text-green-600">{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif
                        <br><tbody>
                            <form method="POST">
                                @csrf
                                <label for="accountFrom">{{ __('Choose your account') }}:</label>
                                <br>
                                <select name = "accountFrom" id="accountFrom">
                                    @foreach($accounts as $account)
                                        <option value = {{ $account->number }}>{{ $account->number }}/
                                            {{ number_format($account->balance / 100, 2) }}/
                                            {{ $account->currency }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <br><label for="receiver">{{ __('Receiver') }}:</label>
                                <input id="receiver" name="receiver" type="text"
                                       class="block p-1 pl-10 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <br><label for="accountTo">{{ __('Receiver number') }}:</label>
                                <input id="accountTo" name="accountTo" type="text"
                                       class="block p-1 pl-10 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <br><label for="amount">{{ __('Amount') }}:</label>
                                <input id="amount" name="amount" type="text"
                                       class="block p-1 pl-10 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <br><label for="comment">{{ __('Comment') }}:</label>
                                <input id="comment" name="comment" type="text"
                                       class="block p-1 pl-10 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <br><button type="submit" formaction="/makePayment" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    {{ __('Make payment') }}
                                </button>
                            </form>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
@endsection

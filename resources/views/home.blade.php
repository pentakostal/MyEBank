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
            <p class="text-red-600">
                @if($errors->any())
                    {{ implode('', $errors->all(':message')) }}
                @endif
            </p>
            <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                Accounts
            </header>

            <a href="/account" >
                <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Account</button>
            </a>

            <div class="w-full p-6">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Number</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Currency</th>
                            <th scope="col" class="px-6 py-3">Balance</th>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <form method="POST">
                                    @csrf
                                    <input type="hidden" id="number" name="number" value="{{ $account->number }}">
                                    <input type="hidden" id="balance" name="balance" value="{{ $account->balance }}">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $account->number }}</td>
                                    <td class="px-6 py-4">{{ $account->status }}</td>
                                    <td class="px-6 py-4">{{ $account->currency }}</td>
                                    <td class="px-6 py-4">{{ number_format($account->balance / 100, 2) }}{{ $account->currencySymbol }}</td>
                                    <td class="px-6 py-4">
                                        <input id="newBalance" name="newBalance" type="number"
                                               class="block p-2 pl-1 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <br>
                                        <button type="submit" formaction="/addMoney"class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                            {{ __('Add Money') }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button type="submit" formaction="/deleteAccount" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                            {{ __('Delete Account') }}
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
                    Transaction between your accounts
                </header>
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li class="text-green-600">{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif

                        <br>
                <form method="POST">
                    @csrf
                    <p>From Account:</p>
                    <input id="fromAccount" name="fromAccount" type="text"
                           class="block p-2 pl-1 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <p>To Account:</p>
                    <input id="toAccount" name="toAccount" type="text"
                           class="block p-2 pl-1 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <p>Amount</p>
                    <input id="transactionAmount" name="transactionAmount" type="text"
                           class="block p-2 pl-1 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <button type="submit" formaction="/transactionAccount" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        {{ __('Transit') }}
                    </button>
                </form>
            </section>
    </div>
</main>
@endsection

@extends('layouts.app')
@extends('layouts.validation')

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
                    Your key card
                </header>

                <div class="w-full p-6">
                        @for ($i = 0; $i < 10; $i++)
                            <p>{{ $i + 1 }}) {{ $codes[$i] }}</p>
                        @endfor
                </div>
            </section>
        </div>
    </main>
@endsection

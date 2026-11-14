@extends('layouts.app')

@section('title', 'Masuk | PT. Solusi Net Nusantara')

@section('content')
<section class="container-page py-16 sm:py-24">
    <div class="mx-auto max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
        <p class="eyebrow">AKUN ANDA</p>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">Masuk</h1>
        <p class="mt-2 text-sm leading-6 text-gray-600">Masuk ke akun Anda untuk melanjutkan.</p>

        @if (session('status'))
            <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="status">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Kata sandi</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            <button type="submit" class="button button-primary w-full">Masuk</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Belum memiliki akun? <a href="{{ route('register') }}" class="font-semibold text-blue-800 hover:underline">Daftar</a>
        </p>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('title', 'Daftar | PT. Solusi Net Nusantara')

@section('content')
<section class="container-page py-16 sm:py-24">
    <div class="mx-auto max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
        <p class="eyebrow">MULAI SEKARANG</p>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">Buat akun</h1>
        <p class="mt-2 text-sm leading-6 text-gray-600">Daftar untuk mengajukan permintaan layanan.</p>

        @if ($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Nama lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Kata sandi</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <p class="mt-2 text-xs text-gray-500">Gunakan minimal 8 karakter.</p>
            </div>
            <button type="submit" class="button button-primary w-full">Daftar</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="font-semibold text-blue-800 hover:underline">Masuk</a>
        </p>
    </div>
</section>
@endsection

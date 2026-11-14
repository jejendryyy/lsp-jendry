@extends('layouts.app')
@section('title', $product->name . ' | PT. Solusi Net Nusantara')
@section('content')
<article class="product-detail">
    <a href="{{ route('products.index') }}" class="product-back-link">← Kembali ke produk &amp; layanan</a>
    @if (session('success'))
        <div class="product-status" role="status">
            {{ session('success') }}
        </div>
    @endif
    <div class="product-detail-layout">
        <div class="product-detail-media">
            @if ($product->image_url)
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
            @else
                <div class="product-image-placeholder" role="img" aria-label="Gambar {{ $product->name }}">
                    <span>Solusi infrastruktur</span>
                    <strong>{{ $product->name }}</strong>
                </div>
            @endif
        </div>
        <div class="product-detail-copy">
            @if ($product->category)
                <p class="product-detail-category">{{ $product->category->name }}</p>
            @endif
            @if ($product->server_specs)
                <p class="product-detail-specs">{{ $product->server_specs }}</p>
            @endif
            <h1>{{ $product->name }}</h1>
            <p class="product-detail-price">{{ $product->price }}</p>
            @if ($product->full_description)
                <div class="product-detail-rich-text">{!! $product->full_description !!}</div>
            @endif
            <div class="product-detail-actions">
                <a href="{{ route('contact', ['product_id' => $product->id]) }}" class="button button-primary product-consult-link">Konsultasi layanan</a>
            </div>
        </div>
    </div>
</article>
@endsection

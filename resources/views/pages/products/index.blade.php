@extends('layouts.app')
@section('title', 'Layanan | PT. Solusi Net Nusantara')
@section('content')
<section class="hero">
  <div class="container-page hero-content">
    <p class="eyebrow">SERVICE CATALOG</p>
    <h1>Layanan Cloud & Data Center yang Fleksibel</h1>
    <p>Pilih fondasi yang tepat untuk aplikasi, data, dan operasional penting Anda dengan desain yang dapat diskalakan.</p>
  </div>
</section>
<section class="section" style="background: #fafafa;">
  <div class="container-page">
    <div class="cards">
      @forelse($products as $item)
        <article class="card">
          @if($item->image_url)
            <img class="w-full aspect-video object-cover" src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
          @else
            <div class="aspect-video grid place-items-center bg-gradient-to-br from-slate-900 to-slate-800 text-blue-400 text-xs tracking-widest uppercase">Infrastructure Service</div>
          @endif
          <div class="card-body">
            @if($item->category)
              <span class="card-label">{{ $item->category->name }}</span>
            @endif
            @if($item->server_specs)
              <p class="product-card-specs">{{ $item->server_specs }}</p>
            @endif
            <h3>{{ $item->name }}</h3>
            <p>{{ $item->short_description }}</p>
            <p class="card-price">{{ $item->price }}</p>
            <a class="inline-block mt-5 font-bold text-sm" style="color: var(--brand-primary)" href="{{ route('products.show', $item->slug) }}">Baca Detail →</a>
          </div>
        </article>
      @empty
        <p>Belum ada layanan aktif.</p>
      @endforelse
    </div>
    <div style="margin-top: 48px;">{{ $products->links() }}</div>
  </div>
</section>
@endsection

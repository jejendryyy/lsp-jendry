@extends('layouts.app')
@section('title', 'Dokumentasi | PT. Solusi Net Nusantara')
@section('content')
<section class="hero">
  <div class="container-page hero-content">
    <p class="eyebrow">Dokumentasi</p>
    <h1>Gambaran solusi dan fasilitas kami</h1>
    <p>Dokumentasi yang membantu Anda memahami pendekatan Cloud & Data Center secara lebih dekat.</p>
  </div>
</section>
<section class="section" style="background: #f9fafb;">
  <div class="container-page">
    <div class="section-heading center">
      <p class="eyebrow">DOKUMENTASI LAYANAN</p>
      <h2>Fokus pada Kebutuhan Operasional</h2>
    </div>
    <div class="cards">
      @forelse($galleries as $item)
        <article class="card">
          @if($item->image_path)
            <img class="w-full aspect-video object-cover" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
          @else
            <div class="aspect-video grid place-items-center bg-slate-800 text-white text-xs">Cloud & Data Center</div>
          @endif
          <div class="card-body">
            <span class="card-label">{{ $item->project_tag }}</span>
            <h3>{{ $item->title }}</h3>
            <p>{{ $item->caption }}</p>
          </div>
        </article>
      @empty
        <p>Dokumentasi akan diperbarui.</p>
      @endforelse
    </div>
    <div class="mt-12">{{ $galleries->links() }}</div>
  </div>
</section>
@endsection

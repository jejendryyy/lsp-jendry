@extends('layouts.app')
@section('title', 'Tentang Kami | PT. Solusi Net Nusantara')
@section('content')
<section class="hero">
  <div class="container-page hero-content">
    <p class="eyebrow">TENTANG PERUSAHAAN</p>
    <h1>Mitra Infrastruktur untuk Operasional Digital Anda</h1>
    <p>PT. Solusi Net Nusantara menyediakan solusi Cloud & Data Center dengan komunikasi yang jelas, spesifikasi terukur, dan pendekatan yang bertanggung jawab.</p>
  </div>
</section>
<section class="section" style="background: #fafafa;">
  <div class="container-page">
    <div class="section-heading center">
      <p class="eyebrow">TENTANG KAMI</p>
      <h2>Fondasi Infrastruktur Digital yang Tangguh untuk Bisnis Anda</h2>
      <p>{{ $profile?->deskripsi ?? 'PT. Solusi Net Nusantara menghadirkan layanan komputasi awan, colocation, dan pemulihan bencana berstandar tinggi guna memastikan kelangsungan operasional perusahaan tanpa henti.' }}</p>
    </div>
  </div>
</section>
<section class="section section-soft visi-misi-section">
  <div class="container-page">
    <div class="section-heading center">
      <h2>Visi & Misi</h2>
      <p>Landasan kami dalam menghadirkan konektivitas dan teknologi yang memberi manfaat.</p>
    </div>
    <div class="visi-misi-grid">
      <article class="visi-misi-card visi-misi-card--vision">
        <h3 class="visi-misi-label">Visi</h3>
        @if ($profile?->visi)
          <p class="visi-misi-vision">{{ $profile->visi }}</p>
        @else
          <p class="visi-misi-vision">Menjadi mitra terpercaya dalam transformasi infrastruktur digital Indonesia.</p>
          <p class="visi-misi-supporting">Membantu organisasi membangun operasional digital yang tangguh dan siap berkembang melalui solusi yang andal.</p>
        @endif
      </article>
      <article class="visi-misi-card visi-misi-card--mission">
        <h3 class="visi-misi-label">Misi</h3>
        @if ($profile?->misi)
          @php
            $missions = preg_split('/\r\n|\r|\n|\s+-\s+/u', trim($profile->misi));
            $missions = array_values(array_filter(array_map(
                fn ($mission) => trim($mission, " \t\n\r\0\x0B-"),
                $missions ?: []
            )));
          @endphp
          <ul class="visi-misi-list">
            @foreach ($missions as $mission)
              <li>{{ $mission }}</li>
            @endforeach
          </ul>
        @else
          <p class="visi-misi-intro">Memberikan solusi infrastruktur yang handal, transparan, dan berkelanjutan.</p>
          <ul class="visi-misi-list">
            <li>Menyediakan layanan konektivitas dan teknologi sesuai kebutuhan pelanggan.</li>
            <li>Menjaga kualitas layanan melalui dukungan yang responsif dan berkelanjutan.</li>
            <li>Membangun hubungan kerja sama yang jujur, profesional, dan saling tumbuh.</li>
          </ul>
        @endif
      </article>
    </div>
  </div>
</section>
@endsection

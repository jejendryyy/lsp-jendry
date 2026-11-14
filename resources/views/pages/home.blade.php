@extends('layouts.app')
@section('title', 'PT. Solusi Net Nusantara | Cloud & Data Center')
@section('content')
<section class="hero">
  <div class="container-page">
    <div class="hero-content">
      <p class="eyebrow">ENTERPRISE INFRASTRUCTURE CATALOG 2026</p>
      <h1>Solusi Cloud & Data Center Terintegrasi</h1>
      <p>Pilih opsi layanan yang disesuaikan dengan kebutuhan operasional bisnis Anda. Interkoneksi ultra-rendah latensi dengan jaminan redundansi fisik mutlak.</p>
      <div class="hero-buttons">
        <a class="button button-primary" href="{{ route('products.index') }}">Jelajahi Paket Layanan →</a>
        <a class="button button-secondary" href="{{ route('contact') }}">Konsultasi Solusi Kustom</a>
      </div>
    </div>

  </div>
</section>

<section class="section" style="background: #fafafa;">
  <div class="container-page">
    <div class="section-heading center">
      <p class="eyebrow">AKSELERATOR & SPESIALISASI</p>
      <h2>Infrastruktur Berstandar Misi Kritis</h2>
      <p>Dirancang untuk mendukung kebutuhan komplikasi korporat, perbankan, dan ekosistem digital transaksi real-time</p>
    </div>
    <div class="feature-grid">
      <article class="feature">
        <div class="feature-icon" style="background: #eff6ff; color: #1e40af;">
          <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 10a2 2 0 114 0 2 2 0 01-4 0z"/></svg>
        </div>
        <span class="feature-badge">FACILITY FINGERPRINT</span>
        <h3>Colocation & Footprint Physic</h3>
        <p>Primer konfigurasi dual-level PSU dengan air conditioning redundansi mutlak. Lokasi muka-2 dekat ke backbone IXP multi-carrier mewah.</p>
        <ul class="feature-list">
          <li><span class="check-icon">✓</span> Dual Redundant A+B PSU Infrastructure</li>
          <li><span class="check-icon">✓</span> Penyewaan 1/2 cabinet hingga full cage/booth</li>
          <li><span class="check-icon">✓</span> Redundant cooling dual/triple paths</li>
        </ul>
      </article>
      <article class="feature">
        <div class="feature-icon" style="background: #eff6ff; color: #1e40af;">
          <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>
        </div>
        <span class="feature-badge">NETWORK SECURITY</span>
        <h3>Bandwidth & Interkoneksi</h3>
        <p>Bandwidth akumulasi antar format BGP dengan layanan backup di Carrier Y Dedikasi sekunder dengan mengiming dampingi layer-3 private interlink.</p>
        <ul class="feature-list">
          <li><span class="check-icon">✓</span> Owner Neutral Peering format BCP</li>
          <li><span class="check-icon">✓</span> Macro Time Respond untuk migrasi Carrier-2</li>
          <li><span class="check-icon">✓</span> Konektivitas meluas dual upstream diversify</li>
        </ul>
      </article>
      <article class="feature">
        <div class="feature-icon" style="background: #eff6ff; color: #1e40af;">
          <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
        </div>
        <span class="feature-badge">SLA & LIAB SERRATED</span>
        <h3>SLA & Operasional Guarantee</h3>
        <p>Konstruksi kombinasi Availability bertahap perseroan-teknikal dimutasi dengan SG eksperimental kredensial verifikasa independen (lembaga-survei).</p>
        <ul class="feature-list">
          <li><span class="check-icon">✓</span> 99.98% Service uptime SLA tersertifikat</li>
          <li><span class="check-icon">✓</span> Audit & Compliance: PCI-DSS Tipe I Seduce</li>
          <li><span class="check-icon">✓</span> External watchdog dan engineer on-site</li>
        </ul>
      </article>
    </div>
  </div>
</section>

<section class="section section-soft" id="services">
  <div class="container-page">
    <div class="section-heading">
      <p class="eyebrow">LAYANAN UNGGULAN</p>
      <h2>Solusi yang dapat disesuaikan dengan kebutuhan Anda</h2>
      <p>Paket layanan dengan spesifikasi yang jelas dan dukungan konsultasi sebelum implementasi.</p>
    </div>
    <div class="cards">
      @forelse($featuredProducts->take(3) as $item)
        <article class="card">
          @if($item->image_url)
            <img class="w-full aspect-[16/9] object-cover" src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}">
          @else
            <div class="aspect-[16/9] grid place-items-center bg-gray-800 text-gray-300 text-xs tracking-widest uppercase">Infrastructure Service</div>
          @endif
          <div class="card-body">
            @if($item->category)
              <span class="card-label">{{ $item->category->name }}</span>
            @endif
            <h3>{{ $item->name }}</h3>
            <p>{{ $item->short_description }}</p>
            <div class="spec-list">
              <span class="spec-pill">{{ $item->server_specs }}</span>
            </div>
            <p class="card-price">{{ $item->price }}</p>
            <a class="inline-block mt-5 font-bold text-sm" style="color: var(--brand-primary)" href="{{ route('products.show', $item->slug) }}">Lihat Detail Layanan →</a>
          </div>
        </article>
      @empty
        <p>Katalog layanan sedang diperbarui.</p>
      @endforelse
    </div>
  </div>
</section>
@endsection

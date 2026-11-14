<header class="site-header">
  <div class="container-page nav-wrap">
    <a href="{{ route('home') }}" class="brand-mark"><img class="brand-logo" src="{{ asset('images/admin-logo-dark.png') }}" alt="Logo PT. Solusi Net Nusantara"><span></span></a>
    <nav class="site-nav" aria-label="Navigasi utama">
      <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')]) @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
       <a href="{{ route('profile') }}" @class(['is-active' => request()->routeIs('profile')]) @if(request()->routeIs('profile')) aria-current="page" @endif>Profil</a>
      <a href="{{ route('products.index') }}" @class(['is-active' => request()->routeIs('products.*')]) @if(request()->routeIs('products.*')) aria-current="page" @endif>Produk &amp; Layanan</a>
      <a href="{{ route('gallery') }}" @class(['is-active' => request()->routeIs('gallery')]) @if(request()->routeIs('gallery')) aria-current="page" @endif>Galeri</a>
      <a href="{{ route('contact') }}" @class(['is-active' => request()->routeIs('contact')]) @if(request()->routeIs('contact')) aria-current="page" @endif>Kontak</a>
    </nav>
    <div class="nav-actions">
      @auth
        <span class="nav-account">Halo, {{ auth()->user()->name }}</span>
        <form class="nav-logout" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="button button-primary nav-cta">Keluar</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="button nav-login nav-cta">Masuk</a>
        <a href="{{ route('register') }}" class="button button-primary nav-cta">Daftar</a>
      @endauth
    </div>
  </div>
</header>

@extends('layouts.app')
@section('title', 'Kontak | PT. Solusi Net Nusantara')
@section('content')
  <section class="hero">
    <div class="container-page hero-content">
      <p class="eyebrow">HUBUNGI KAMI</p>
      <h1>Mari Mulai Percakapan</h1>
      <p>Ceritakan kebutuhan infrastruktur Anda. Tim kami siap membantu memetakan langkah berikutnya dengan solusi yang
        tepat sasaran.</p>
    </div>
  </section>
  <section class="section" style="background: #f9fafb;">
    <div class="container-page grid gap-16 md:grid-cols-2">
      <div>
        <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 32px;">Detail Kontak</h2>
        <div style="display: grid; gap: 32px; font-size: 14px;">
          <div>
            <b style="font-weight: 700; font-size: 15px; display: block; margin-bottom: 10px;">Alamat</b>
            <p style="color: var(--muted); line-height: 1.6;">Kp.Pabuaran No.47</p>
          </div>
          <div>
            <b style="font-weight: 700; font-size: 15px; display: block; margin-bottom: 10px;">Email</b>
            <p style="color: var(--muted);">jendrylangelo07@solusinetnusantara.com</p>
          </div>
          <div>
            <b style="font-weight: 700; font-size: 15px; display: block; margin-bottom: 10px;">Telepon</b>
            <p style="color: var(--muted);">+62 895-1626-9095</p>
          </div>
        </div>
        <div style="margin-top: 40px;">

        </div>
      </div>
      <div>
        <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 32px;">Kirim Pesan</h2>
        @if(session('success'))
          <div
            style="background: #ecfdf5; border: 1px solid #d1fae5; border-radius: 16px; padding: 16px; margin-bottom: 24px; color: #065f46; font-size: 14px;">
            {{ e(session('success')) }}</div>
        @endif
        @if ($errors->any())
          <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
            <ul class="list-inside list-disc space-y-1">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form method="POST" action="{{ route('contact.submit') }}"
          data-authenticated="{{ auth()->check() ? 'true' : 'false' }}" style="display: grid; gap: 20px;">
          @csrf
          <label id="contact-name-field" style="display: block;">
            <span style="font-size: 13px; font-weight: 700; color: var(--ink); display: block; margin-bottom: 10px;">Nama
              <span style="color: #dc2626;">*</span></span>
            <input class="w-full border border-slate-200 rounded-xl p-4"
              style="font-size: 14px; border: 1px solid var(--border); border-radius: 12px; padding: 12px 16px; transition: all 0.2s;"
              name="sender_name" value="{{ auth()->user()?->name ?? old('sender_name') }}" @auth readonly @else required
              @endauth>
          </label>
          <label id="contact-email-field" style="display: block;">
            <span style="font-size: 13px; font-weight: 700; color: var(--ink); display: block; margin-bottom: 10px;">Email
              <span style="color: #dc2626;">*</span></span>
            <input class="w-full border border-slate-200 rounded-xl p-4"
              style="font-size: 14px; border: 1px solid var(--border); border-radius: 12px; padding: 12px 16px; transition: all 0.2s;"
              type="email" name="sender_email" value="{{ auth()->user()?->email ?? old('sender_email') }}" @auth readonly
              @else required @endauth>
          </label>
          <label style="display: block;">
            <span style="font-size: 13px; font-weight: 700; color: var(--ink); display: block; margin-bottom: 10px;">Nomor
              Telepon <span style="color: #dc2626;">*</span></span>
            <input id="contact-phone" class="w-full border border-slate-200 rounded-xl p-4"
              style="font-size: 14px; border: 1px solid var(--border); border-radius: 12px; padding: 12px 16px; transition: all 0.2s;"
              name="sender_phone" value="{{ old('sender_phone') }}" maxlength="30" required>
          </label>
          <label style="display: block;">
            <span
              style="font-size: 13px; font-weight: 700; color: var(--ink); display: block; margin-bottom: 10px;">Layanan
              (opsional)</span>
            <select id="contact-product" class="w-full border border-slate-200 rounded-xl p-4"
              style="font-size: 14px; border: 1px solid var(--border); border-radius: 12px; padding: 12px 16px; transition: all 0.2s;"
              name="product_id">
              <option value="">Pesan umum — tidak memilih layanan</option>
              @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected((string) old('product_id', request()->query('product_id')) === (string) $product->id)>{{ $product->name }}</option>
              @endforeach
            </select>
          </label>
          <label style="display: block;">
            <span style="font-size: 13px; font-weight: 700; color: var(--ink); display: block; margin-bottom: 10px;">Pesan
              (opsional)</span>
            <textarea id="contact-message" class="w-full border border-slate-200 rounded-xl p-4"
              style="font-size: 14px; border: 1px solid var(--border); border-radius: 12px; padding: 12px 16px; transition: all 0.2s; font-family: inherit;"
              name="message" rows="5" maxlength="5000">{{ old('message') }}</textarea>
          </label>
          <button id="contact-submit" class="button button-primary w-full" style="width: 100%; margin-top: 8px;">Kirim
            Pesan</button>
        </form>
      </div>
    </div>
  </section>
  @auth
    <section class="section" style="background: #fff;">
      <div class="container-page">
        <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 24px;">Riwayat Permintaan Layanan</h2>
        @if ($serviceRequests->isEmpty())
          <p style="color: var(--muted); border: 1px solid var(--border); border-radius: 12px; padding: 20px;">Anda belum
            memiliki riwayat permintaan layanan.</p>
        @else
          <div style="overflow-x: auto; border: 2px solid #171717; border-radius: 18px;">
            <table style="width: 100%; min-width: 560px; border-collapse: collapse; text-align: left;">
              <thead>
                <tr style="background: #E5E7EB; border-bottom: 2px solid #171717;">
                  <th scope="col" style="padding: 18px 22px; font-size: 15px; font-weight: 700;">Tanggal</th>
                  <th scope="col" style="padding: 18px 22px; font-size: 15px; font-weight: 700;">Layanan</th>
                  <th scope="col" style="padding: 18px 22px; font-size: 15px; font-weight: 700;">Status</th>
                  <th scope="col" style="padding: 18px 22px; font-size: 15px; font-weight: 700;">Tindakan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($serviceRequests as $serviceRequest)
                  @php
                    $statusLabel = match ($serviceRequest->status) {
                      \App\Models\ServiceRequest::STATUS_APPROVED => 'Disetujui',
                      \App\Models\ServiceRequest::STATUS_ACTIVE => 'Aktif',
                      \App\Models\ServiceRequest::STATUS_NONACTIVE => 'Non aktif',
                      
                      default => 'Menunggu',
                    };
                    $statusColors = match ($serviceRequest->status) {
                      \App\Models\ServiceRequest::STATUS_APPROVED => ['#166534', '#dcfce7'],
                      \App\Models\ServiceRequest::STATUS_ACTIVE => ['#166534', '#dcfce7'],
                      \App\Models\ServiceRequest::STATUS_NONACTIVE => ['#757575 ', '#ebedef'],
                      
                      default => ['#92400e', '#fef3c7'],
                    };
                  @endphp
                  <tr style="background: #fff; {{ $loop->last ? '' : 'border-bottom: 1px solid #171717;' }}">
                    <td style="padding: 18px 22px; font-size: 15px;">{{ $serviceRequest->created_at->format('d M Y') }}</td>
                    <td style="padding: 18px 22px; font-size: 15px;">{{ $serviceRequest->product->name }}</td>
                    <td style="padding: 18px 22px;">
                      <span
                        style="display: inline-flex; align-items: center; border-radius: 9999px; padding: 4px 10px; color: {{ $statusColors[0] }}; background: {{ $statusColors[1] }}; font-size: 12px; font-weight: 700; line-height: 1.5;">
                        {{ $statusLabel }}
                      </span>
                    </td>
                    <td>
                     @if ($serviceRequest->status === \App\Models\ServiceRequest::STATUS_APPROVED)
                       @php
                          $paymentMessage = 'Halo, saya ingin melanjutkan pembayaran untuk layanan '
                            . $serviceRequest->product->name
                            . ' (pengajuan tanggal ' . $serviceRequest->created_at->format('d M Y') . ').';
                        @endphp

                        <a href="https://wa.me/6289516269095?text={{ rawurlencode($paymentMessage) }}" target="_blank"
                          rel="noopener noreferrer"
                          style="display: inline-block; padding: 8px 12px; border-radius: 8px; background: #16a34a; color: #fff; font-weight: 700; text-decoration: none;">
                          Lakukan Pembayaran
                        </a>
                     @endif 
                     @if ($serviceRequest->status === \App\Models\ServiceRequest::STATUS_NONACTIVE)
                       @php
                          $paymentMessage = 'Halo, saya ingin melakukan perpanjangan untuk layanan '
                            . $serviceRequest->product->name
                            . ' (pengajuan tanggal ' . $serviceRequest->created_at->format('d M Y') . ').';
                        @endphp

                        <a href="https://wa.me/6289516269095?text={{ rawurlencode($paymentMessage) }}" target="_blank"
                          rel="noopener noreferrer"
                          style="display: inline-block; padding: 8px 12px; border-radius: 8px; background: #16a34a; color: #fff; font-weight: 700; text-decoration: none;">
                          Lakukan Perpanjangan
                        </a>
                     @endif 
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div style="margin-top: 20px;">{{ $serviceRequests->links() }}</div>
        @endif
      </div>
    </section>
  @endauth
@endsection
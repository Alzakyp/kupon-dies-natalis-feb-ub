<x-layouts.app>
<p class="eyebrow">Detail batch</p><h1>{{ $batch->name }}</h1>
<div class="summary-card"><div><small>Status</small><p><strong>{{ $batch->active ? 'Aktif' : 'Nonaktif' }}</strong></p></div><div><small>Kedaluwarsa</small><p>{{ $batch->expires_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</p></div></div>
<p><a class="button" href="{{ url('/admin/batches/'.$batch->id.'/export') }}">Unduh ZIP kupon</a></p>
<nav class="filters" aria-label="Filter kupon"><a href="?filter=all" @if($filter==='all')aria-current="page"@endif>Semua</a><a href="?filter=unredeemed" @if($filter==='unredeemed')aria-current="page"@endif>Belum digunakan</a><a href="?filter=redeemed" @if($filter==='redeemed')aria-current="page"@endif>Sudah digunakan</a></nav>
<div class="table-wrap"><table><thead><tr><th>Kode</th><th>Peserta</th><th>Status</th><th>Waktu penukaran</th><th>IP</th></tr></thead><tbody>@forelse($coupons as $coupon)<tr><td class="code-badge">{{ $coupon->code }}</td><td>{{ $coupon->ticket?->number ?? 'Belum dialokasikan' }}</td><td>{{ $coupon->redeemed_at ? 'Sudah digunakan' : 'Belum digunakan' }}</td><td>{{ $coupon->redeemed_at?->timezone('Asia/Jakarta')->format('d M Y H:i').' WIB' ?? '—' }}</td><td>{{ $coupon->redeemed_ip ?? '—' }}</td></tr>@empty<tr><td colspan="5">Tidak ada kupon.</td></tr>@endforelse</tbody></table></div>{{ $coupons->links() }}
</x-layouts.app>

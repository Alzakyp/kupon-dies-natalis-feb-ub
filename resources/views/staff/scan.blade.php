<x-layouts.app>
<p class="eyebrow">Meja check-in</p><h1>Dashboard petugas</h1>
<div class="dashboard-stats"><div><small>Total tiket</small><strong>{{ $total }}</strong></div><div><small>Sudah check-in</small><strong>{{ $checkedIn }}</strong></div><div><small>Belum check-in</small><strong>{{ $total - $checkedIn }}</strong></div></div>
<section class="panel"><h2>Scan QR tiket</h2><p>Scan QR dari email peserta. Scanner USB otomatis mengisi kode dan menekan Enter.</p><form method="post" action="{{ url('/staff/lookup') }}">@csrf<label>Kode tiket<input name="barcode" autofocus required autocomplete="off" spellcheck="false"></label><button>Cari tiket</button></form></section>
<section><h2>10 tiket terbaru</h2><div class="table-wrap"><table><thead><tr><th>Tiket</th><th>Peserta</th><th>Status</th></tr></thead><tbody>@forelse($recent as $ticket)<tr><td><a href="{{ url('/staff/tickets/'.$ticket->id) }}">{{ $ticket->number }}</a></td><td>{{ $ticket->studentRegistry?->name ?? $ticket->email }}</td><td>{{ $ticket->checked_in_at ? 'Sudah check-in' : 'Belum check-in' }}</td></tr>@empty<tr><td colspan="3">Belum ada tiket.</td></tr>@endforelse</tbody></table></div></section>
</x-layouts.app>

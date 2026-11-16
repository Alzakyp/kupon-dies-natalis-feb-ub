<x-layouts.app>
<p class="eyebrow">Detail batch</p><h1>{{ $batch->name }}</h1>
<div class="summary-card"><div><small>Status</small><p><strong>{{ $batch->active ? 'Aktif' : 'Nonaktif' }}</strong></p></div><div><small>Kedaluwarsa</small><p>{{ $batch->expires_at }}</p></div></div>
<p><a class="button" href="{{ url('/admin/batches/'.$batch->id.'/export') }}">Unduh ZIP kupon</a></p>
</x-layouts.app>

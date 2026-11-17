<x-layouts.app>
    <style id="print-page-rules">
        @page {
            size: 47mm 31mm;
            margin: 0;
        }
    </style>

    <div class="print-page-wrapper">
        <div class="print-control-bar no-print">
            <div class="control-left">
                <a href="{{ url('/staff/tickets/'.$ticket->id) }}" class="btn-back">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    <span>Kembali ke Detail</span>
                </a>
                <span class="paper-size-pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                    <span>Ukuran: <strong id="label-dimension">47 × 31 mm (Landscape)</strong></span>
                </span>
            </div>
            <div class="control-right">
                <div class="button-group orientation-group" role="group" aria-label="Orientasi Kertas">
                    <button type="button" class="btn-toggle active" data-set-orientation="landscape" title="Orientasi Landscape 47 x 31 mm">
                        Landscape (47×31)
                    </button>
                    <button type="button" class="btn-toggle" data-set-orientation="portrait" title="Orientasi Portrait 31 x 47 mm">
                        Portrait (31×47)
                    </button>
                </div>

                <div class="button-group zoom-group" role="group" aria-label="Skala Zoom Layar">
                    <button type="button" class="btn-toggle-zoom" data-scale="1" title="Ukuran Sebenarnya (1:1)">100%</button>
                    <button type="button" class="btn-toggle-zoom active" data-scale="2.2" title="Zoom Pratinjau (220%)">220%</button>
                </div>

                <button type="button" class="btn-primary btn-print-now" data-print-ticket>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect width="12" height="8" x="6" y="14"/>
                    </svg>
                    <span>Print Tiket Sekarang</span>
                </button>
            </div>
        </div>

        @if($ticket->print_requests > 1)
            <div class="print-warning-banner no-print">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <span>Peringatan: Tiket ini sudah pernah dicetak sebelumnya (Cetakan ke-{{ $ticket->print_requests }}). Stempel cetak ulang aktif.</span>
            </div>
        @endif

        <!-- Staging Preview Area -->
        <div class="print-preview-stage">
            <div class="stage-scaler" id="stage-scaler" style="transform: scale(2.2); transform-origin: top center;">
                <div id="physical-ticket" class="ticket-physical-template orientation-landscape">
                    <div class="ticket-bg-layer" aria-hidden="true"></div>

                    @if($ticket->print_requests > 1)
                        <div class="reprint-watermark" aria-hidden="true">CETAK ULANG</div>
                    @endif

                    <!-- Sisi Kiri: QR Code (Kiri Tengah) & Nomor Undian di Bawahnya -->
                    <div class="ticket-col-left">
                        <div class="ticket-qr-wrap" title="QR Kupon Undian Batch">
                            {!! \App\Services\BarcodeSvg::render(url('/c/'.$ticket->coupon->code)) !!}
                        </div>
                        <div class="ticket-lottery-box">
                            <span class="lottery-tag">NO. UNDIAN</span>
                            <strong class="lottery-val">#{{ str_pad($ticket->coupon->id, 4, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Brand & Informasi Peserta -->
                    <div class="ticket-col-right">
                        <div class="ticket-brand-header">
                            <div class="brand-top-row">
                                <span class="brand-dies">DIES NATALIS 65</span>
                                <span class="brand-lustrum">LUSTRUM XIII</span>
                            </div>
                            <span class="brand-org">FEB UNIVERSITAS BRAWIJAYA</span>
                        </div>

                        <div class="ticket-participant-info">
                            <div class="p-name" title="{{ $ticket->studentRegistry?->name ?? $ticket->email }}">
                                {{ \Illuminate\Support\Str::limit($ticket->studentRegistry?->name ?? $ticket->email, 22) }}
                            </div>
                            <div class="p-subinfo">
                                <span class="p-prodi" title="{{ $ticket->studentRegistry?->study_program ?? 'FEB UB' }}">
                                    {{ \Illuminate\Support\Str::limit($ticket->studentRegistry?->study_program ?? 'FEB UB', 20) }}
                                </span>
                                <span class="p-nim">{{ $ticket->studentRegistry?->nim ?? $ticket->number }}</span>
                            </div>
                        </div>

                        <div class="ticket-footer-strip">
                            <span class="batch-tag-pill">{{ \Illuminate\Support\Str::limit($ticket->coupon->batch->name ?? 'Kupon', 12) }}</span>
                            <span class="ticket-valid-date">{{ $ticket->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="print-guide-box no-print">
            <div class="guide-icon" aria-hidden="true">💡</div>
            <div class="guide-content">
                <strong>Panduan Cetak Printer Label Thermal (31 × 47 mm):</strong>
                <ul>
                    <li>Pada dialog printer (Ctrl+P / Cmd+P), pilih printer label thermal Anda.</li>
                    <li>Pastikan ukuran kertas (Paper Size) disetel ke <strong>47 × 31 mm</strong> (atau 31 × 47 mm sesuai orientasi roll printer Anda).</li>
                    <li>Atur <strong>Margins: None / Nol</strong> dan aktifkan opsi <strong>Background graphics</strong> agar border dan warna tampil tajam.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var btnPrint = document.querySelector('[data-print-ticket]');
        if (btnPrint) {
            btnPrint.addEventListener('click', function () {
                window.print();
            });
        }

        var toggleBtns = document.querySelectorAll('[data-set-orientation]');
        var ticket = document.getElementById('physical-ticket');
        var labelDim = document.getElementById('label-dimension');
        var printPageRules = document.getElementById('print-page-rules');

        toggleBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                toggleBtns.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                var ori = btn.getAttribute('data-set-orientation');
                if (ori === 'portrait') {
                    ticket.classList.remove('orientation-landscape');
                    ticket.classList.add('orientation-portrait');
                    if (labelDim) labelDim.textContent = '31 × 47 mm (Portrait)';
                    if (printPageRules) printPageRules.textContent = '@page { size: 31mm 47mm; margin: 0; }';
                } else {
                    ticket.classList.remove('orientation-portrait');
                    ticket.classList.add('orientation-landscape');
                    if (labelDim) labelDim.textContent = '47 × 31 mm (Landscape)';
                    if (printPageRules) printPageRules.textContent = '@page { size: 47mm 31mm; margin: 0; }';
                }
            });
        });

        var zoomBtns = document.querySelectorAll('[data-scale]');
        var scaler = document.getElementById('stage-scaler');
        zoomBtns.forEach(function (zBtn) {
            zBtn.addEventListener('click', function () {
                zoomBtns.forEach(function (b) { b.classList.remove('active'); });
                zBtn.classList.add('active');
                var s = zBtn.getAttribute('data-scale');
                if (scaler) {
                    scaler.style.transform = 'scale(' + s + ')';
                }
            });
        });
    });
    </script>
</x-layouts.app>
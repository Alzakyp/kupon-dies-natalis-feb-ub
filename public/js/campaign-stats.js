(() => {
    const root = document.getElementById('campaign-poll');
    if (!root) return;

    const refresh = async () => {
        try {
            const r = await fetch(root.dataset.url, { headers: { Accept: 'application/json' } });
            if (!r.ok) return;
            const d = await r.json();

            // Update all [data-metric] elements
            document.querySelectorAll('[data-metric]').forEach(e => {
                const metricKey = e.dataset.metric;
                const val = d[metricKey];
                if (typeof val === 'number') {
                    e.textContent = val.toLocaleString('id-ID');
                } else if (val !== undefined && val !== null) {
                    e.textContent = val;
                }
            });

            // Update campaign status badge
            const statusEl = document.getElementById('campaign-status');
            if (statusEl) {
                if (d.running) {
                    statusEl.className = 'campaign-status-pill status-running';
                    statusEl.innerHTML = '<span class="live-dot"></span><span>Pengiriman Aktif</span>';
                } else {
                    statusEl.className = 'campaign-status-pill status-paused';
                    statusEl.innerHTML = '<span class="pause-dot"></span><span>Pengiriman Dijeda</span>';
                }
            }

            // Update quota meter
            const barEl = document.getElementById('quota-progress-bar');
            const textEl = document.getElementById('quota-progress-text');
            if (barEl && d.limit) {
                const pct = Math.min(100, Math.round(((d.attemptsToday || 0) / d.limit) * 100));
                barEl.style.width = pct + '%';
                if (pct >= 85) {
                    barEl.className = 'quota-bar-fill fill-danger';
                } else if (pct >= 60) {
                    barEl.className = 'quota-bar-fill fill-warning';
                } else {
                    barEl.className = 'quota-bar-fill fill-safe';
                }
                if (textEl) {
                    textEl.textContent = (d.attemptsToday || 0).toLocaleString('id-ID') + ' / ' + d.limit.toLocaleString('id-ID') + ' (' + pct + '%)';
                }
            }

            // Update timestamp
            const updatedEl = document.getElementById('campaign-updated');
            if (updatedEl) {
                const now = new Date();
                const timeStr = String(now.getHours()).padStart(2, '0') + '.' +
                               String(now.getMinutes()).padStart(2, '0') + '.' +
                               String(now.getSeconds()).padStart(2, '0');
                updatedEl.textContent = 'Diperbarui ' + timeStr + ' WIB · Diterima SMTP bukan bukti masuk Inbox.';
            }
        } catch (_) {}
    };

    refresh();
    setInterval(refresh, 5000);
})();

document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || form.dataset.noLoading !== undefined) return;
    const loading = document.getElementById('submit-loading');
    if (!loading) return;
    const submitter = event.submitter || form.querySelector('button[type="submit"],button:not([type])');
    if (submitter) {
        submitter.disabled = true;
        submitter.dataset.label = submitter.textContent;
        submitter.textContent = 'Memproses…';
    }
    loading.hidden = false;
});

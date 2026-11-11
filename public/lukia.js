document.querySelectorAll('form[data-confirm]').forEach(form => form.addEventListener('submit', event => { if (!window.confirm(form.dataset.confirm)) event.preventDefault(); }));

document.querySelectorAll('[data-notice]').forEach(notice => {
    let timer;

    const close = () => {
        notice.classList.add('is-hiding');
        window.setTimeout(() => notice.remove(), 200);
    };

    const startTimer = () => {
        timer = window.setTimeout(close, notice.classList.contains('lukia-notice-error') ? 8000 : 5000);
    };

    notice.querySelector('[data-notice-close]')?.addEventListener('click', close);
    notice.addEventListener('mouseenter', () => window.clearTimeout(timer));
    notice.addEventListener('mouseleave', startTimer);
    startTimer();
});

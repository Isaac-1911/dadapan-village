document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-modal-target]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            document.getElementById(trigger.dataset.modalTarget)?.classList.add('is-open');
            document.body.classList.add('admin-modal-open');
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((closer) => {
        closer.addEventListener('click', () => {
            closer.closest('.admin-modal')?.classList.remove('is-open');
            document.body.classList.remove('admin-modal-open');
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.admin-modal.is-open').forEach((m) => m.classList.remove('is-open'));
            document.body.classList.remove('admin-modal-open');
        }
    });
});

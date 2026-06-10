const confirmForms = document.querySelectorAll('[data-confirm]');

confirmForms.forEach((form) => {
    form.addEventListener('submit', (event) => {
        const message = form.getAttribute('data-confirm');

        if (message && !window.confirm(message)) {
            event.preventDefault();
        }
    });
});

const requestForm = document.querySelector('[data-request-form]');

if (requestForm) {
    const titleInput = requestForm.querySelector('input[name="title"]');

    if (titleInput) {
        const counter = document.createElement('small');
        counter.className = 'muted';
        titleInput.insertAdjacentElement('afterend', counter);

        const updateCounter = () => {
            counter.textContent = `${titleInput.value.length}/120 tekens`;
        };

        titleInput.addEventListener('input', updateCounter);
        updateCounter();
    }
}

const filterForm = document.querySelector('[data-filter-form]');

if (filterForm) {
    filterForm.querySelectorAll('select').forEach((select) => {
        select.addEventListener('change', () => filterForm.submit());
    });
}

const revealItems = document.querySelectorAll('.reveal');

if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.14 });

    revealItems.forEach((item) => revealObserver.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}

const counters = document.querySelectorAll('[data-count]');

counters.forEach((counter) => {
    const target = Number(counter.getAttribute('data-count') || '0');
    let current = 0;
    const step = Math.max(1, Math.ceil(target / 24));

    const tick = () => {
        current = Math.min(target, current + step);
        counter.textContent = String(current);

        if (current < target) {
            window.requestAnimationFrame(tick);
        }
    };

    counter.textContent = '0';
    window.requestAnimationFrame(tick);
});

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

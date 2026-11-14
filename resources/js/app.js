// Entry point for small progressive enhancements.

const contactProduct = document.querySelector('#contact-product');

if (contactProduct instanceof HTMLSelectElement) {
    const form = contactProduct.form;
    const nameField = document.querySelector('#contact-name-field');
    const emailField = document.querySelector('#contact-email-field');
    const phoneField = document.querySelector('#contact-phone');
    const submitButton = document.querySelector('#contact-submit');
    const isAuthenticated = form?.dataset.authenticated === 'true';

    const updateFormMode = () => {
        const isServiceRequest = contactProduct.value !== '';

        if (nameField instanceof HTMLElement) {
            nameField.hidden = false;
            const input = nameField.querySelector('input');
            input?.toggleAttribute('required', !isAuthenticated);
        }

        if (emailField instanceof HTMLElement) {
            emailField.hidden = false;
            const input = emailField.querySelector('input');
            input?.toggleAttribute('required', !isAuthenticated);
        }

        if (phoneField instanceof HTMLInputElement) {
            phoneField.required = isServiceRequest;
        }

        if (submitButton instanceof HTMLButtonElement) {
            submitButton.textContent = isServiceRequest ? 'Ajukan Permintaan' : 'Kirim Pesan';
        }
    };

    contactProduct.addEventListener('change', updateFormMode);
    updateFormMode();
}

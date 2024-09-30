document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-button');
    const deleteButtons = document.querySelectorAll('.delete-button');

    editButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-id');
            const modal = document.querySelector(`#${modalId}`);
            if (modal) {
                modal.style.display = 'block';
            }
        });
    });

    deleteButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-id');
            const modal = document.querySelector(`#${modalId}`);
            if (modal) {
                modal.style.display = 'block';
            }
        });
    });

    const modals = document.querySelectorAll('.modal');

    modals.forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
});

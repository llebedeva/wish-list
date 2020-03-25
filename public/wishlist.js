const createBtn = document.getElementById('createButton');
const editBtns = document.querySelectorAll('button[name="edit"]');
const deleteBtns = document.querySelectorAll('input[name="delete"]');

const wishModal = document.getElementById('wishModal');
const closeBtn = document.querySelector('.close');
const addBtn = document.getElementById('add');
const updateBtn = document.getElementById('update');

const wishInput = wishModal.querySelector('input[name="wish"]');
const linkInput = wishModal.querySelector('input[name="link"]');
const descriptionInput = wishModal.querySelector('textarea[name="description"]');
const priorityInput = wishModal.querySelector('input[name="priority"]'); // Temporary field
const priorityLabel = wishModal.querySelector('label[for="priority"]'); // Temporary field
const idInput = wishModal.querySelector('input[name="id"]');

createBtn.onclick = () => {
    wishInput.value = null;
    linkInput.value = null;
    descriptionInput.value = null;
    idInput.value = null;

    hide(priorityInput);
    hide(priorityLabel);

    show(addBtn);
    hide(updateBtn);

    show(wishModal);
};

closeBtn.onclick = () => {
    hide(wishModal);
};

window.onclick = event => {
    if (event.target === wishModal) {
        hide(wishModal);
    }
};

editBtns.forEach(button => {
    button.onclick = event => {
        const tableRow = event.target.parentElement.parentElement;

        wishInput.value = tableRow.querySelector('td').innerHTML;
        linkInput.value = tableRow.querySelector('td:nth-child(2) a').innerHTML;
        descriptionInput.value = tableRow.querySelector('td:nth-child(3)').innerHTML;
        idInput.value = tableRow.querySelector('input[name="id"]').value;

        show(priorityInput);
        show(priorityLabel);

        hide(addBtn);
        show(updateBtn);

        show(wishModal);
    }
});

const show = element => {
    element.classList.add('show');
    element.classList.remove('hide');
};

const hide = element => {
    element.classList.add('hide');
    element.classList.remove('show');
};

deleteBtns.forEach(button => {
    button.onclick = event => {
        const tableRow = event.target.parentElement.parentElement.parentElement;
        const wish = tableRow.querySelector('td').innerHTML;

        if (!confirm(`Remove ${wish}?`)) {
            event.preventDefault();
        }
    }
});

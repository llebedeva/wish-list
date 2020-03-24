const createBtn = document.getElementById('createButton');
const editBtns = document.querySelectorAll('button[name="edit"]');

const modal = document.getElementById('modal');
const closeBtn = document.querySelector('.close');
const addBtn = document.getElementById('add');
const updateBtn = document.getElementById('update');

const wishInput = modal.querySelector('input[name="wish"]');
const linkInput = modal.querySelector('input[name="link"]');
const descriptionInput = modal.querySelector('textarea[name="description"]');
const idInput = modal.querySelector('input[name="id"]');

createBtn.onclick = () => {
    wishInput.value = null;
    linkInput.value = null;
    descriptionInput.value = null;
    idInput.value = null;

    show(addBtn);
    hide(updateBtn);

    show(modal);
};

closeBtn.onclick = () => {
    hide(modal);
};

window.onclick = event => {
    if (event.target === modal) {
        hide(modal);
    }
};

editBtns.forEach(button => {
    button.onclick = event => {
        const tableRow = event.target.parentElement.parentElement;

        wishInput.value = tableRow.querySelector('td').innerHTML;
        linkInput.value = tableRow.querySelector('td:nth-child(2) a').innerHTML;
        descriptionInput.value = tableRow.querySelector('td:nth-child(3)').innerHTML;
        idInput.value = tableRow.querySelector('input[name="id"]').value;

        hide(addBtn);
        show(updateBtn);

        show(modal);
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

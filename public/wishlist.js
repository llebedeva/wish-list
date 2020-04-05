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
const idInput = wishModal.querySelector('input[name="id"]');

createBtn.onclick = () => {
    wishInput.value = null;
    linkInput.value = null;
    descriptionInput.value = null;
    idInput.value = null;

    show(addBtn);
    hide(updateBtn);

    show(wishModal);
};

closeBtn.onclick = () => {
    hide(wishModal);
};

editBtns.forEach(button => {
    button.onclick = event => {
        const listItem = event.target.parentElement.parentElement;

        wishInput.value = listItem.querySelector('div').innerHTML;
        linkInput.value = listItem.querySelector('div:nth-child(2) a').innerHTML;
        descriptionInput.value = listItem.querySelector('div:nth-child(3)').innerHTML;
        idInput.value = listItem.querySelector('input[name="id"]').value;

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
        const wish = tableRow.querySelector('div').innerHTML;

        if (!confirm(`Remove ${wish}?`)) {
            event.preventDefault();
        }
    }
});

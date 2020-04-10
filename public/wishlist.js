import {serialize} from './lib.js';
const createBtn = document.getElementById('createButton');
const editBtns = document.querySelectorAll('button[name="edit"]');
const deleteBtns = document.querySelectorAll('button[name="delete"]');

const confirmModal = document.getElementById('confirmModal');
const confirmMessage = confirmModal.querySelector('p');
const yesBtn = confirmModal.querySelector('button[name="ok"]');
const noBtn = confirmModal.querySelector('button[name="cancel"]');

const wishModal = document.getElementById('wishModal');
const closeBtn = document.querySelector('.close');
const title = document.querySelector('h3');
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

    title.innerHTML = 'Create new wish';

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

        title.innerHTML = 'Edit wish';

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
        const item = event.target.parentElement.parentElement;
        const wishValue = item.querySelector('div').innerHTML;
        const wishId = item.querySelector('input[name="id"]').value;

        confirmMessage.innerHTML = `Remove ${wishValue}?`;
        show(confirmModal);

        yesBtn.onclick = async () => {
            hide(confirmModal);
            hide(item);
            await deleteWish(wishId);
        };

        noBtn.onclick = () => {
            hide(confirmModal);
        };
    }
});

const deleteWish = async (wishId) => {
    try {
        const response = await fetch('/', {
            method: 'POST',
            headers: {'Content-type': 'application/x-www-form-urlencoded'},
            body: serialize({id: wishId, delete: 'Delete'})
        });
        if (!(response.ok)) {
            // noinspection ExceptionCaughtLocallyJS
            throw new Error('Request failed!');
        }
    } catch(error){
        console.log(error);
    }
};

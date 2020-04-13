import {serialize} from './lib.js';

const wishList = document.getElementById('list');
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

closeBtn.onclick = () => {
    hide(wishModal);
};

const editHandler = event => {
    const listItem = event.target.parentElement.parentElement;

    wishInput.value = listItem.querySelector('div').innerHTML;
    linkInput.value = listItem.querySelector('div:nth-child(2) a').innerHTML;
    descriptionInput.value = listItem.querySelector('div:nth-child(3)').innerHTML;
    idInput.value = listItem.querySelector('input[name="id"]').value;

    title.innerHTML = 'Edit wish';

    hide(addBtn);
    show(updateBtn);

    show(wishModal);
    getFocus();
};

const deleteHandler = event => {
    const item = event.target.parentElement.parentElement;
    const wishValue = item.querySelector('div').innerHTML;
    const wishId = item.querySelector('input[name="id"]').value;

    confirmMessage.innerHTML = `Remove ${wishValue}?`;
    show(confirmModal);

    yesBtn.onclick = async () => {
        hide(confirmModal);
        hide(item);
        await deleteWishPOST(wishId);
    };

    noBtn.onclick = () => {
        hide(confirmModal);
    };
};

createBtn.onclick = () => {
    wishInput.value = null;
    linkInput.value = null;
    descriptionInput.value = null;
    idInput.value = null;

    title.innerHTML = 'Create new wish';

    show(addBtn);
    hide(updateBtn);

    show(wishModal);
    getFocus();
};

addBtn.onclick = async () => {
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionInput.value;

    const id = await createWishPOST(wish, link, description);
    wishList.insertAdjacentHTML('beforeend', `<div class="list-group-item">
            <div>${wish}</div>
            <div><a href="${link}">${link}</a></div>
            <div>${description}</div>
            <div>
                <input type="hidden" name="id" value="${id}">
                <button name="edit">Edit</button>
                <button name="delete">Delete</button>
            </div>
        </div>`);
    document.querySelectorAll('.list-group-item:last-child button[name="edit"]')[0].onclick = editHandler;
    document.querySelectorAll('.list-group-item:last-child button[name="delete"]')[0].onclick = deleteHandler;

    hide(wishModal);
};

editBtns.forEach(button => {
    button.onclick = editHandler;
});

updateBtn.onclick = async () => {
    const id = idInput.value;
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionInput.value;

    await updateWishPOST(id, wish, link, description);

    hide(wishModal);
};

const show = element => {
    element.classList.add('show');
    element.classList.remove('hide');
};

const hide = element => {
    element.classList.add('hide');
    element.classList.remove('show');
};

const getFocus = () => {
    wishInput.focus();
};

deleteBtns.forEach(button => {
    button.onclick = deleteHandler;
});

const createWishPOST = async (wish, link, description) => {
    try {
        const response = await fetch('/', {
            method: 'POST',
            headers: {'Content-type': 'application/x-www-form-urlencoded'},
            body: serialize({wish: wish, link: link, description: description, add: 'add'})
        });
        if (response.ok) {
            let json = await response.json();
            return json.id;
        } else {
            // noinspection ExceptionCaughtLocallyJS
            throw new Error('Request failed! HTTP code=' + response.status);
        }
    } catch(error){
        console.log(error);
    }
};

const updateWishPOST = async (id, wish, link, description) => {
    try {
        const response = await fetch('/', {
            method: 'POST',
            headers: {'Content-type': 'application/x-www-form-urlencoded'},
            body: serialize({id: id, wish: wish, link: link, description: description, update: 'update'})
        });
        if (!(response.ok)) {
            // noinspection ExceptionCaughtLocallyJS
            throw new Error('Request failed!');
        }
    } catch(error){
        console.log(error);
    }
};

const deleteWishPOST = async wishId => {
    try {
        const response = await fetch('/', {
            method: 'POST',
            headers: {'Content-type': 'application/x-www-form-urlencoded'},
            body: serialize({id: wishId, delete: 'delete'})
        });
        if (!(response.ok)) {
            // noinspection ExceptionCaughtLocallyJS
            throw new Error('Request failed!');
        }
    } catch(error){
        console.log(error);
    }
};

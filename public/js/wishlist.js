import {createWishAction, updateWishAction, deleteWishAction, changeOrderWishesAction} from "./wishActions.js";
import Sortable from './ext/sortable.complete.esm.js';

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

let currentListItem;

const show = element => {
    element.classList.add('show');
    element.classList.remove('hide');
};

const hide = element => {
    element.classList.add('hide');
    element.classList.remove('show');
};

const focusOnWishInput = () => {
    wishInput.focus();
};

const createHandler = () => {
    wishInput.value = null;
    linkInput.value = null;
    descriptionInput.value = null;
    idInput.value = null;

    title.innerHTML = 'Create new wish';

    show(addBtn);
    hide(updateBtn);

    show(wishModal);
    focusOnWishInput();
};

const editHandler = event => {
    currentListItem = event.target.parentElement.parentElement;

    wishInput.value = currentListItem.querySelector('div').innerHTML;
    linkInput.value = currentListItem.querySelector('div:nth-child(2) a').innerHTML;
    descriptionInput.value = currentListItem.querySelector('div:nth-child(3)').innerHTML;
    idInput.value = currentListItem.querySelector('input[name="id"]').value;

    title.innerHTML = 'Edit wish';

    hide(addBtn);
    show(updateBtn);

    show(wishModal);
    focusOnWishInput();
};

const deleteHandler = event => {
    const item = event.target.parentElement.parentElement;
    const wishValue = item.querySelector('div').innerHTML;
    const wishId = item.querySelector('input[name="id"]').value;

    confirmMessage.innerHTML = `Remove ${wishValue}?`;
    show(confirmModal);

    yesBtn.onclick = async () => {
        await deleteWishAction(wishId);
        wishList.removeChild(item);
        hide(confirmModal);
    };

    noBtn.onclick = () => {
        hide(confirmModal);
    };
};

const enterKeyPressHandler = event => {
    if(event.keyCode === 13){
        submitWishModal();
    }
};

const submitWishModal = () => {
    if (addBtn.classList.value === 'show') {
        addBtn.click();
    } else if (updateBtn.classList.value === 'show') {
        updateBtn.click();
    }
};

createBtn.onclick = createHandler;

addBtn.onclick = async () => {
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionInput.value;

    const id = await createWishAction(wish, link, description);

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
    document.querySelector('.list-group-item:last-child button[name="edit"]').onclick = editHandler;
    document.querySelector('.list-group-item:last-child button[name="delete"]').onclick = deleteHandler;

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

    await updateWishAction(id, wish, link, description);

    currentListItem.querySelector('div:nth-child(1)').innerHTML = wish;
    const a = currentListItem.querySelector('div:nth-child(2) a');
    a.innerHTML = link;
    a.setAttribute('href', link);
    currentListItem.querySelector('div:nth-child(3)').innerHTML = description;

    hide(wishModal);
};

deleteBtns.forEach(button => {
    button.onclick = deleteHandler;
});

closeBtn.onclick = () => {
    hide(wishModal);
};

wishInput.onkeydown = enterKeyPressHandler;
linkInput.onkeydown = enterKeyPressHandler;
descriptionInput.onkeydown = enterKeyPressHandler;

if (wishList !== null) {
    Sortable.create(wishList, {
        multiDrag: true,
        fallbackTolerance: 3,
        animation: 150,

        onEnd: async function (/**Event*/evt) {
            const oldIndex = evt.oldIndex;
            const newIndex = evt.newIndex;
            if (oldIndex !== newIndex) {
                await changeOrderWishesAction(oldIndex, newIndex);
            }
        }
    });
}

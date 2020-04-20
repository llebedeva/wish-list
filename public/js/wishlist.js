import {createWishAction, updateWishAction, deleteWishAction, changeOrderWishesAction} from './wishActions.js';
import {hide} from './style.js';
import {enterKeyPressHandler, closeWishModal, confirmDeleting, openEditWishModal, openCreateWishModal, closeBtn, updateFunc} from './wishLib.js';
import Sortable from './ext/sortable.complete.esm.js';

const wishList = document.getElementById('list');
const createBtn = document.getElementById('createButton');
const editBthPath = 'button[name="edit"]';
const editBtns = document.querySelectorAll(editBthPath);
const deleteBthPath = 'button[name="delete"]';
const deleteBtns = document.querySelectorAll(deleteBthPath);

const addBtn = document.getElementById('add');
const updateBtn = document.getElementById('update');

const wishInputPath = 'input[name="wish"]';
const wishInput = wishModal.querySelector(wishInputPath);
const linkInputPath = 'input[name="link"]';
const linkInput = wishModal.querySelector(linkInputPath);
const descriptionInputPath = 'input[name="description"]';
const descriptionTextareaPath = 'textarea[name="description"]';
const descriptionTextarea = wishModal.querySelector(descriptionTextareaPath);
const idInputPath = 'input[name="id"]';
const idInput = wishModal.querySelector(idInputPath);

let currentListItem;

const editHandler = event => {
    currentListItem = event.target.parentElement.parentElement;
    const wishValue = currentListItem.querySelector(wishInputPath).value;
    const linkValue = currentListItem.querySelector(linkInputPath).value;
    const descriptionValue = currentListItem.querySelector(descriptionInputPath).value;
    const idValue = currentListItem.querySelector(idInputPath).value;

    openEditWishModal(wishValue, linkValue, descriptionValue, idValue);
};

const deleteHandler = event => {
    const item = event.target.parentElement.parentElement;
    const wishValue = item.querySelector(wishInputPath).value;
    const wishIdValue = item.querySelector(idInputPath).value;

    confirmDeleting(wishValue, async () => {
        await deleteWishAction(wishIdValue);
        await wishList.removeChild(item);
    });
};

createBtn.onclick = openCreateWishModal;

addBtn.onclick = async () => {
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionTextarea.value;

    const id = await createWishAction(wish, link, description);

    wishList.insertAdjacentHTML('beforeend', `<div class="list-group-item">
            <div><a href="/wish/${id}">${wish}</a></div>
            <div>
                <input type="hidden" name="wish" value="${wish}">
                <input type="hidden" name="link" value="${link}">
                <input type="hidden" name="description" value="${description}">
                <input type="hidden" name="id" value="${id}">
                <button name="edit">Edit</button>
                <button name="delete">Delete</button>
            </div>
        </div>`);
    const lastListItemPath = '.list-group-item:last-child'
    document.querySelector(lastListItemPath + ' ' + editBthPath).onclick = editHandler;
    document.querySelector(lastListItemPath + ' ' + deleteBthPath).onclick = deleteHandler;

    hide(wishModal);
};

editBtns.forEach(button => {
    button.onclick = editHandler;
});

updateBtn.onclick = async () => {
    const id = idInput.value;
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionTextarea.value;

    await updateWishAction(id, wish, link, description);

    currentListItem.querySelector('div a').innerHTML = wish;
    currentListItem.querySelector(wishInputPath).value = wish;
    currentListItem.querySelector(linkInputPath).value = link;
    currentListItem.querySelector(descriptionInputPath).value = description;
    currentListItem.querySelector(idInputPath).value = id;

    await closeWishModal();
};

deleteBtns.forEach(button => {
    button.onclick = deleteHandler;
});

wishInput.onkeydown = enterKeyPressHandler;
linkInput.onkeydown = enterKeyPressHandler;
descriptionTextarea.onkeydown = enterKeyPressHandler;

closeBtn.onclick = closeWishModal;

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

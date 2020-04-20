import {createWishAction, updateWishAction, deleteWishAction, changeOrderWishesAction} from "./wishActions.js";
import {show, hide} from "./style.js";
import Sortable from './ext/sortable.complete.esm.js';

const wishList = document.getElementById('list');
const createBtn = document.getElementById('createButton');
const editBthPath = 'button[name="edit"]';
const editBtns = document.querySelectorAll(editBthPath);
const deleteBthPath = 'button[name="delete"]';
const deleteBtns = document.querySelectorAll(deleteBthPath);

const confirmModal = document.getElementById('confirmModal');
const confirmMessage = confirmModal.querySelector('p');
const yesBtn = confirmModal.querySelector('button[name="ok"]');
const noBtn = confirmModal.querySelector('button[name="cancel"]');

const wishModal = document.getElementById('wishModal');
const closeBtn = document.querySelector('.close');
const title = document.querySelector('h3');
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

const focusOnWishInput = () => {
    wishInput.focus();
};

const createHandler = () => {
    wishInput.value = null;
    linkInput.value = null;
    descriptionTextarea.value = null;
    idInput.value = null;

    title.innerHTML = 'Create new wish';

    show(addBtn);
    hide(updateBtn);

    show(wishModal);
    focusOnWishInput();
};

const editHandler = event => {
    currentListItem = event.target.parentElement.parentElement;

    wishInput.value = currentListItem.querySelector(wishInputPath).value;
    linkInput.value = currentListItem.querySelector(linkInputPath).value;
    descriptionTextarea.value = currentListItem.querySelector(descriptionInputPath).value;
    idInput.value = currentListItem.querySelector(idInputPath).value;

    title.innerHTML = 'Edit wish';

    hide(addBtn);
    show(updateBtn);

    show(wishModal);
    focusOnWishInput();
};

const deleteHandler = event => {
    const item = event.target.parentElement.parentElement;
    const wishValue = item.querySelector(wishInputPath).value;
    const wishId = item.querySelector(idInputPath).value;

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
descriptionTextarea.onkeydown = enterKeyPressHandler;

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

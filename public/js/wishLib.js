import {hide, show} from "./style.js";
import {createWishAction, updateWishAction, deleteWishAction} from "./wishActions.js";

export const wishList = document.getElementById('list');
export const editBthPath = 'button[name="edit"]';
export const deleteBthPath = 'button[name="delete"]';
const closeBtnPath = '.close';
const title = document.querySelector('h3');

const wishModal = document.getElementById('wishModal');
export const closeBtn = wishModal.querySelector(closeBtnPath);
export const addBtn = document.getElementById('add');
export const updateBtn = document.getElementById('update');

const confirmModal = document.getElementById('confirmModal');
const confirmMessage = confirmModal.querySelector('p');
const yesBtn = confirmModal.querySelector('button[name="ok"]');
const noBtn = confirmModal.querySelector('button[name="cancel"]');

export const wishInputPath = 'input[name="wish"]';
export const linkInputPath = 'input[name="link"]';
export const descriptionInputPath = 'input[name="description"]';
export const descriptionTextareaPath = 'textarea[name="description"]';
export const idInputPath = 'input[name="id"]';

export const wishInput = wishModal.querySelector(wishInputPath);
export const linkInput = wishModal.querySelector(linkInputPath);
export const descriptionTextarea = wishModal.querySelector(descriptionTextareaPath);
const idInput = wishModal.querySelector(idInputPath);


const focusOnWishInput = () => {
    wishInput.focus();
};

export const enterKeyPressHandler = event => {
    if (event.keyCode === 13) {
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

export const closeWishModal = () => {
    hide(wishModal);
};

export const confirmDeleting = (wishValue, wishIdValue, confirmHandler) => {
    confirmMessage.innerHTML = `Remove ${wishValue}?`;
    show(confirmModal);

    const hideConfirmModal = () => {
        hide(confirmModal);
    };

    yesBtn.onclick = async () => {
        await deleteWishAction(wishIdValue);
        confirmHandler();
        hideConfirmModal();
    };

    noBtn.onclick = hideConfirmModal;
    confirmModal.querySelector(closeBtnPath).onclick = hideConfirmModal;
};

export const openEditWishModal = (wishValue, linkValue, descriptionValue, idValue) => {
    wishInput.value = wishValue;
    linkInput.value = linkValue;
    descriptionTextarea.value = descriptionValue;
    idInput.value = idValue;

    title.innerHTML = 'Edit wish';

    hide(addBtn);
    show(updateBtn);

    show(wishModal);
    focusOnWishInput();
};

export const openCreateWishModal = () => {
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

export const createWish = async () => {
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionTextarea.value;

    const id = await createWishAction(wish, link, description);
    await closeWishModal();

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
};

export const updateFunc = async (item, changeAppearance) => {
    const id = idInput.value;
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionTextarea.value;

    await updateWishAction(id, wish, link, description);
    await closeWishModal();

    changeAppearance(wish, link, description)

    item.querySelector(wishInputPath).value = wish;
    item.querySelector(linkInputPath).value = link;
    item.querySelector(descriptionInputPath).value = description;
    item.querySelector(idInputPath).value = id;
};

import {hide, show} from "./style.js";
import {updateWishAction} from "./wishActions.js";

const wishModal = document.getElementById('wishModal');
const closePath = '.close';
export const closeBtn = wishModal.querySelector(closePath);
const title = document.querySelector('h3');
const addBtn = document.getElementById('add');
const updateBtn = document.getElementById('update');

const confirmModal = document.getElementById('confirmModal');
const confirmMessage = confirmModal.querySelector('p');
const yesBtn = confirmModal.querySelector('button[name="ok"]');
const noBtn = confirmModal.querySelector('button[name="cancel"]');

const wishInputPath = 'input[name="wish"]';
const wishInput = wishModal.querySelector(wishInputPath);
const linkInputPath = 'input[name="link"]';
const linkInput = wishModal.querySelector(linkInputPath);
const descriptionInputPath = 'input[name="description"]';
const descriptionTextareaPath = 'textarea[name="description"]';
const descriptionTextarea = wishModal.querySelector(descriptionTextareaPath);
const idInputPath = 'input[name="id"]';
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

export const confirmDeleting = (wishValue, confirmHandler) => {
    confirmMessage.innerHTML = `Remove ${wishValue}?`;
    show(confirmModal);

    const hideConfirmModal = () => {
        hide(confirmModal);
    };

    yesBtn.onclick = () => {
        confirmHandler();
        hideConfirmModal();
    };

    noBtn.onclick = hideConfirmModal;
    confirmModal.querySelector(closePath).onclick = hideConfirmModal;
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

export const updateFunc = async () => {
    const id = idInput.value;
    const wish = wishInput.value;
    const link = linkInput.value;
    const description = descriptionTextarea.value;

    await updateWishAction(id, wish, link, description);

    await hide(wishModal);
};

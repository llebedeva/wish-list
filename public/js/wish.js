import {updateWishAction, deleteWishAction} from './wishActions.js';
import {enterKeyPressHandler, confirmDeleting, openEditWishModal, closeBtn, closeWishModal} from './wishLib.js';

const wishItem = document.getElementById('wishItem');

const editBthPath = 'button[name="edit"]';
const editBtn = document.querySelector(editBthPath);
const deleteBthPath = 'button[name="delete"]';
const deleteBtn = document.querySelector(deleteBthPath);

const wishModal = document.getElementById('wishModal');
const title = document.querySelector('h3');
const addBtn = document.getElementById('add');
const updateBtn = document.getElementById('update');

const wishInputPath = 'input[name="wish"]';
// const wishInput = wishModal.querySelector(wishInputPath);
const linkInputPath = 'input[name="link"]';
// const linkInput = wishModal.querySelector(linkInputPath);
const descriptionInputPath = 'input[name="description"]';
// const descriptionInput = wishModal.querySelector(descriptionInputPath);
const descriptionTextareaPath = 'textarea[name="description"]';
// const descriptionTextarea = wishModal.querySelector(descriptionTextareaPath);
const idInputPath = 'input[name="id"]';
// const idInput = wishModal.querySelector(idInputPath);

const backLink = document.getElementById('back');

editBtn.onclick = () => {
    const wishValue = document.querySelector(wishInputPath).value;
    const linkValue = document.querySelector(linkInputPath).value;
    const descriptionValue = document.querySelector(descriptionInputPath).value;
    const idValue = document.querySelector(idInputPath).value;

    openEditWishModal(wishValue, linkValue, descriptionValue, idValue);
};

deleteBtn.onclick = () => {
    const wishValue = document.querySelector(wishInputPath).value;
    const wishIdValue = document.querySelector(idInputPath).value;

    confirmDeleting(wishValue, async () => {
        await deleteWishAction(wishIdValue);
        await backLink.click();
    });
};

updateBtn.onclick = async () => {
    const id = wishModal.querySelector(idInputPath).value;
    const wish = wishModal.querySelector(wishInputPath).value;
    const link = wishModal.querySelector(linkInputPath).value;
    const description = wishModal.querySelector(descriptionTextareaPath).value;

    await updateWishAction(id, wish, link, description);

    document.querySelector('div:nth-child(1)').innerHTML = wish;
    document.querySelector('div:nth-child(2) a').innerHTML = link;
    document.querySelector('div:nth-child(3)').innerHTML = description;

    wishItem.querySelector(wishInputPath).value = wish;
    wishItem.querySelector(linkInputPath).value = link;
    wishItem.querySelector(descriptionInputPath).value = description;
    wishItem.querySelector(idInputPath).value = id;

    await closeWishModal();
};

wishModal.querySelector(wishInputPath).onkeydown = enterKeyPressHandler;
wishModal.querySelector(linkInputPath).onkeydown = enterKeyPressHandler;
wishModal.querySelector(descriptionTextareaPath).onkeydown = enterKeyPressHandler;

closeBtn.onclick = closeWishModal;

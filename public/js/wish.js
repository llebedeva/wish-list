import {enterKeyPressHandler, confirmDeleting, openEditWishModal, closeWishModal, updateFunc,
    closeBtn, editBthPath, deleteBthPath, updateBtn,
    wishInputPath, linkInputPath, descriptionInputPath, idInputPath,
    wishInput, linkInput, descriptionTextarea} from './wishLib.js';

const wishItem = document.getElementById('wishItem');
const backLink = document.getElementById('back');
const editBtn = document.querySelector(editBthPath);
const deleteBtn = document.querySelector(deleteBthPath);


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

    confirmDeleting(wishValue, wishIdValue, async () => {
        await backLink.click();
    });
};

updateBtn.onclick = async () => {
    await updateFunc(wishItem, (wish, link, description) => {
        document.querySelector('div:nth-child(1)').innerHTML = wish;
        document.querySelector('div:nth-child(2) a').innerHTML = link;
        document.querySelector('div:nth-child(3)').innerHTML = description;
    });
};

wishInput.onkeydown = enterKeyPressHandler;
linkInput.onkeydown = enterKeyPressHandler;
descriptionTextarea.onkeydown = enterKeyPressHandler;

closeBtn.onclick = closeWishModal;

import Sortable from './ext/sortable.complete.esm.js';

import {changeOrderWishesAction} from './wishActions.js';
import {enterKeyPressHandler, closeWishModal, confirmDeleting, openEditWishModal, openCreateWishModal, closeBtn,
    updateFunc, createWish, editBthPath, deleteBthPath, addBtn, updateBtn, wishList,
    wishInputPath, linkInputPath, descriptionInputPath, idInputPath,
    wishInput, linkInput, descriptionTextarea} from './wishLib.js';

const createBtn = document.getElementById('createButton');
const editBtns = document.querySelectorAll(editBthPath);
const deleteBtns = document.querySelectorAll(deleteBthPath);

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

    confirmDeleting(wishValue, wishIdValue, async () => {
        await wishList.removeChild(item);
    });
};

createBtn.onclick = openCreateWishModal;

addBtn.onclick = async () => {
    await createWish();

    const lastListItemPath = '.list-group-item:last-child'
    document.querySelector(lastListItemPath + ' ' + editBthPath).onclick = editHandler;
    document.querySelector(lastListItemPath + ' ' + deleteBthPath).onclick = deleteHandler;
};

editBtns.forEach(button => {
    button.onclick = editHandler;
});

updateBtn.onclick = async () => {
    await updateFunc(currentListItem, (wish, link, description) => {
        currentListItem.querySelector('div a').innerHTML = wish;
    });
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

import {serialize} from "./lib.js";

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

const changeOrderPOST = async (oldIndex, newIndex) => {
    try {
        const response = await fetch('/', {
            method: 'POST',
            headers: {'Content-type': 'application/x-www-form-urlencoded'},
            body: serialize({
                old: oldIndex,
                new: newIndex,
                change_order: 'change_order'})
        });
        if (!(response.ok)) {
            // noinspection ExceptionCaughtLocallyJS
            throw new Error('Request failed!');
        }
    } catch(error){
        console.log(error);
    }
};

export {createWishPOST, updateWishPOST, deleteWishPOST, changeOrderPOST};

import {serialize} from "./lib.js";

const createWishPOST = async (wish, link, description) => {
    const response = await fetch('/', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            wish: wish,
            link: link,
            description: description,
            add: 'add'
        })
    });
    if (response.ok) {
        let json = await response.json();
        return json.id;
    } else {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

const updateWishPOST = async (id, wish, link, description) => {
    const response = await fetch('/', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            id: id,
            wish: wish,
            link: link,
            description: description,
            update: 'update'
        })
    });
    if (!response.ok) {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

const deleteWishPOST = async wishId => {
    const response = await fetch('/', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            id: wishId,
            delete: 'delete'
        })
    });
    if (!(response.ok)) {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

const changeOrderPOST = async (oldIndex, newIndex) => {
    const response = await fetch('/', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            old: oldIndex,
            new: newIndex,
            change_order: 'change_order'
        })
    });
    if (!(response.ok)) {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

export {createWishPOST, updateWishPOST, deleteWishPOST, changeOrderPOST};

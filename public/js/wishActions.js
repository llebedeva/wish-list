import {serialize} from "./lib.js";

const createWishPOST = async (wish, link, description) => {
    const response = await fetch('/create_wish', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            wish: wish,
            link: link,
            description: description
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
    const response = await fetch('/update_wish', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            id: id,
            wish: wish,
            link: link,
            description: description
        })
    });
    if (!response.ok) {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

const deleteWishPOST = async wishId => {
    const response = await fetch('/delete_wish', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            id: wishId
        })
    });
    if (!(response.ok)) {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

const changeOrderPOST = async (oldIndex, newIndex) => {
    const response = await fetch('/change_wish_order', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: serialize({
            old: oldIndex,
            new: newIndex
        })
    });
    if (!(response.ok)) {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

export {createWishPOST, updateWishPOST, deleteWishPOST, changeOrderPOST};

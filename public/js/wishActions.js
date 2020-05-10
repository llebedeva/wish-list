import {serialize} from "./lib.js";

const path = '/wish'

const createWishAction = async (wish, link, description) => {
    const response = await fetch(path, {
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

const updateWishAction = async (id, wish, link, description) => {
    const response = await fetch(path, {
        method: 'PUT',
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

const changeOrderWishesAction = async (oldIndex, newIndex) => {
    const response = await fetch(path + '/order', {
        method: 'PUT',
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

const deleteWishAction = async wishId => {
    const response = await fetch(path + '/' + wishId, {
        method: 'DELETE'
    });
    if (!(response.ok)) {
        console.log('Request failed! HTTP code=' + response.status);
    } else {
        return true;
    }
};

const getWishlist = async () => {
    const response = await fetch('wishlist', {
        method: 'GET',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
    });
    if (response.ok) {
        return await response.json();
    } else {
        console.log('Request failed! HTTP code=' + response.status);
    }
};

export {createWishAction, updateWishAction, deleteWishAction, changeOrderWishesAction, getWishlist};

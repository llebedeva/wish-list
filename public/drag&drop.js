import Sortable from './sortable.complete.esm.js';
import {serialize} from './lib.js';

const element = document.getElementById('list');

if (element !== null) {
    Sortable.create(element, {
        multiDrag: true,
        fallbackTolerance: 3,
        animation: 150,

        onEnd: async function (/**Event*/evt) {
            const oldIndex = evt.oldIndex;
            const newIndex = evt.newIndex;
            if (oldIndex !== newIndex) {
                await changeOrderPOST(oldIndex, newIndex);
            }
        }
    });
}

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

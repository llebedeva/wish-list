import Sortable from './sortable.complete.esm.js';
import {changeOrderPOST} from "./wishActions.js";

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

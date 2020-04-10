import Sortable from './sortable.complete.esm.js';

const element = document.getElementById('list');

if (element !== null) {
    Sortable.create(element, {
        multiDrag: true,
        fallbackTolerance: 3,
        animation: 150,

        onEnd: function (/**Event*/evt) {
            const oldIndex = evt.oldIndex;
            let newIndex = evt.newIndex;
            if (oldIndex !== newIndex) {
                changeOrder(oldIndex, newIndex);
            }
        }
    });
}

const changeOrder = (oldIndex, newIndex) => {
    const xhr = new XMLHttpRequest();
    const url = '/';
    const data = serialize({
        old: oldIndex,
        new: newIndex,
        change_order: 'change_order'
    });

    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(data);

    xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            return xhr.response;
        }
    };
};

const serialize = obj => {
    let str = [];
    for (let p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
};

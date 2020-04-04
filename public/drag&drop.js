import Sortable from './sortable.complete.esm.js';

const element = document.getElementById('list');
Sortable.create(element, {
    multiDrag: true,
    fallbackTolerance: 3,
    animation: 150,

    // Element dragging ended
    onEnd: function (/**Event*/evt) {
        const element = evt.target;
        const oldIndex = evt.oldIndex;
        let newIndex = evt.newIndex;

        if (oldIndex !== newIndex) {
            console.log('change order');
            changeOrder(97, 'wish', 'link', 'desc', -6);
        }
    }
});

const changeOrder = (id, wish, link, description, priority) => {
    const xhr = new XMLHttpRequest();
    const url = '/';
    const data = serialize({
        wish: wish,
        link: link,
        description: description,
        priority: priority,
        id: id,
        update: 'Save'
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

const serialize = function(obj) {
    let str = [];
    for (let p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}
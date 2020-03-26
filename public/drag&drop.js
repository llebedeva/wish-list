import Sortable from './sortable.complete.esm.js';

let element = document.getElementById('list');
Sortable.create(element, {
    multiDrag: true,
    selectedClass: 'selected',
    fallbackTolerance: 3,
    animation: 150
});
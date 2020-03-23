const createBtn = document.querySelector('#createButton');
const editBtns = document.querySelectorAll('button[name="edit"]');

const modal = document.querySelector('#modal');
const span = document.querySelector('.close');
const addBtn = modal.querySelector('#add');
const updateBtn = modal.querySelector('#update');

createBtn.onclick = function() {
    addBtn.style.display = 'block';
    updateBtn.style.display = 'none';

    modal.style.display = 'block';
};

span.onclick = function() {
    modal.style.display = 'none';
};

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

editBtns.forEach((button) => {
    button.onclick = (event) => {
        const tableRow = event.target.parentElement.parentElement;
        modal.querySelector('input[name="wish"]').value = tableRow.querySelector('td').innerHTML;
        modal.querySelector('input[name="link"]').value = tableRow.querySelector('td:nth-child(2) a').innerHTML;
        modal.querySelector('textarea[name="description"]').value = tableRow.querySelector('td:nth-child(3)').innerHTML;
        modal.querySelector('input[name="id"]').value = tableRow.querySelector('input[name="id"]').value;

        addBtn.style.display = 'none';
        updateBtn.style.display = 'block';

        modal.style.display = 'block';
    }
});

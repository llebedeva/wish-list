const createBtn = document.getElementById('createButton');
const editBtns = document.querySelectorAll('button[name="edit"]');

const modal = document.getElementById('modal');
const closeBtn = document.querySelector('.close');
const addBtn = document.getElementById('add');
const updateBtn = document.getElementById('update');

const wishInput = modal.querySelector('input[name="wish"]');
const linkInput = modal.querySelector('input[name="link"]');
const descriptionInput = modal.querySelector('textarea[name="description"]');
const idinput = modal.querySelector('input[name="id"]');

createBtn.onclick = () => {
    wishInput.value = null;
    linkInput.value = null;
    descriptionInput.value = null;
    idinput.value = null;

    addBtn.style.display = 'block';
    updateBtn.style.display = 'none';

    modal.style.display = 'block';
};

closeBtn.onclick = () => {
    modal.style.display = 'none';
};

window.onclick = event => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

editBtns.forEach(button => {
    button.onclick = event => {
        const tableRow = event.target.parentElement.parentElement;

        wishInput.value = tableRow.querySelector('td').innerHTML;
        linkInput.value = tableRow.querySelector('td:nth-child(2) a').innerHTML;
        descriptionInput.value = tableRow.querySelector('td:nth-child(3)').innerHTML;
        idinput.value = tableRow.querySelector('input[name="id"]').value;

        addBtn.style.display = 'none';
        updateBtn.style.display = 'block';

        modal.style.display = 'block';
    }
});

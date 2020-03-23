// Get the modal
const modal = document.getElementById("modal");

// Get the button that opens the modal
const btn = document.getElementById("createButton");

// Get the <span> element that closes the modal
const span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

const editBtns = document.querySelectorAll('button[name="edit"]');

editBtns.forEach((button) => {
    button.onclick = (event) => {
        const tableRow = event.target.parentElement.parentElement;
        modal.querySelector('input[name="wish"]').value = tableRow.querySelector('td').innerHTML;
        modal.querySelector('input[name="link"]').value = tableRow.querySelector('td:nth-child(2) a').innerHTML;
        modal.querySelector('textarea[name="description"]').value = tableRow.querySelector('td:nth-child(3)').innerHTML;
        modal.querySelector('input[name="id"]').value = tableRow.querySelector('input[name="id"]').value;
        modal.style.display = "block";
    }
});

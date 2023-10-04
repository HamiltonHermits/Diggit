//this is js for editing coments

var editButtons = document.querySelectorAll('.editCommentButton');

if (editButtons.length > 0) {
    // Get the modal element
    var modal = document.getElementById('editCommentModal');

    var closeButton = document.getElementById('closeComentsEdit');

    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var commentId = this.getAttribute('data-comment-id');
            var commentText = this.getAttribute('data-comment-text');
            document.getElementById('commentId').value = commentId;
            document.getElementById('editCommentText').value = commentText;
            modal.style.display = 'block';
        });
    });


    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };
}
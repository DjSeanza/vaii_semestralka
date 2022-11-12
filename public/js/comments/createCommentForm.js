function createReplyCommentForm(commentId, text, author, video) {
    deleteAllCreatedForms(commentId, text, author, video);

    let commentContainer = document.querySelector("#comment-" + commentId);
    let formToDelete = document.querySelector("#comment-form-" + commentId);

    if (formToDelete == null) {
        commentContainer.innerHTML += '' +
            '<div class="reply-form-container">' +
            '   <form action="?c=content&a=storeComment" class="video-comment-form" method="post" id="comment-form-' + commentId + '">' +
            '       <input type="hidden" name="video-comment" value="' + text + '">' +
            '       <input type="hidden" name="author" value="' + author + '">' +
            '       <input type="hidden" name="v" value="' + video + '">' +
            '       <input type="hidden" name="reply-to" value="' + commentId + '">' +
            '       <textarea style="resize: none" id="reply-textarea" maxlength="65535" name="video-comment" placeholder="Začnite písať odpoveď..."></textarea>' +
            '       <button type="submit" class="button">Odoslať</button>' +
            '   </form>' +
            '</div>';
    }

    addEventListenerToForm("form#comment-form-" + commentId, "textarea#reply-textarea");
}

function createEditCommentForm(commentId, text, author, video) {
    deleteAllCreatedForms(commentId, text, author, video);

    let button = document.querySelector("button#edit-button-" + commentId);
    let commentContainer = document.querySelector("div.thread-comment-container div#comment-text-" + commentId);

    button.setAttribute("onclick", 'deleteAllCreatedForms("' + commentId + '", "' + text + '", "' + author + '", "' + video + '")');

    commentContainer.innerHTML = '' +
        '<div class="edit-form-container">' +
        '   <form action="?c=content&a=storeComment" class="video-comment-form" method="post" id="comment-form-' + commentId + '">' +
        '       <input type="hidden" name="video-comment" value="' + text + '">' +
        '       <input type="hidden" name="author" value="' + author + '">' +
        '       <input type="hidden" name="v" value="' + video + '">' +
        '       <input type="hidden" name="comment" value="' + commentId + '">' +
        '       <textarea style="resize: none" id="reply-textarea" maxlength="65535" name="video-comment" placeholder="Začnite písať odpoveď...">' + text + '</textarea>' +
        '       <button type="submit" class="button">Odoslať</button>' +
        '   </form>' +
        '</div>';

    addEventListenerToForm("form#comment-form-" + commentId, "textarea#reply-textarea");
}

function deleteAllCreatedForms(commentId, text, author, video) {
    let editForms = document.querySelectorAll("div.edit-form-container form.video-comment-form");
    let replyForms = document.querySelectorAll("div.reply-form-container");

    editForms.forEach(editForm => {
        let textArea = document.querySelector("div.edit-form-container form.video-comment-form textarea#reply-textarea");
        let commentContainer = document.querySelector("div.thread-comment-container div#comment-text-" + commentId);
        let button = document.querySelector("button#edit-button-" + commentId);

        button.setAttribute("onclick", 'createEditCommentForm("' + commentId + '", "' + text + '", "' + author + '", "' + video + '")');
        commentContainer.innerHTML = '<p>' + textArea.innerHTML + '</p>';

        editForm.remove();
    });

    replyForms.forEach(replyForm => replyForm.remove());
}

function addEventListenerToForm(formId, inputId) {
    const formToSubmit = document.querySelector(formId);
    document.querySelector(inputId).addEventListener("keydown", function(event) {
        if (event.keyCode === 13 && !event.shiftKey) {
            event.preventDefault();
            formToSubmit.submit();
        }
    })
}

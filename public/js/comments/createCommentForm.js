function createReplyCommentForm(commentId, text, author, video) {
    let commentContainer = document.querySelector("#comment-" + commentId);

    commentContainer.innerHTML += '' +
        '<div class="reply-form-container">' +
        '   <form action="?c=content&a=storeComment" class="video-comment-form" method="post" id="comment-form">' +
        '       <input type="hidden" name="video-comment" value="' + text + '">' +
        '       <input type="hidden" name="author" value="' + author + '">' +
        '       <input type="hidden" name="v" value="' + video + '">' +
        '       <input type="hidden" name="reply-to" value="' + commentId + '">' +
        '       <textarea style="resize: none" id="reply-textarea" maxlength="65535" name="video-comment" placeholder="Začnite písať odpoveď..."></textarea>' +
        '       <button type="submit" class="button">Odoslať</button>' +
        '   </form>' +
        '</div>';

    addEventListenerToForm("form#comment-form", "textarea#reply-textarea");
}

function createEditCommentForm(commentId, text, author, video) {
    let commentContainer = document.querySelector("div.thread-comment-container div#comment-text-" + commentId);
    console.log(commentContainer);

    commentContainer.innerHTML = '' +
        '<div class="edit-form-container">' +
        '   <form action="?c=content&a=storeComment" class="video-comment-form" method="post" id="comment-form">' +
        '       <input type="hidden" name="video-comment" value="' + text + '">' +
        '       <input type="hidden" name="author" value="' + author + '">' +
        '       <input type="hidden" name="v" value="' + video + '">' +
        '       <input type="hidden" name="comment" value="' + commentId + '">' +
        '       <textarea style="resize: none" id="reply-textarea" maxlength="65535" name="video-comment" placeholder="Začnite písať odpoveď...">' + text + '</textarea>' +
        '       <button type="submit" class="button">Odoslať</button>' +
        '   </form>' +
        '</div>';

    addEventListenerToForm("form#comment-form", "textarea#reply-textarea");
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

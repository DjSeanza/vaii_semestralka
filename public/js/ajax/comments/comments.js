function createReplyCommentForm(commentId, text, author, video) {
    deleteAllCreatedForms(commentId, text, author, video);

    let commentContainer = document.querySelector("#comment-" + commentId);
    let formToDelete = document.querySelector("#comment-form-" + commentId);

    if (formToDelete == null) {
        commentContainer.innerHTML += '' +
            '<div class="reply-form-container">' +
            '   <form class="video-comment-form" method="post" action="?c=content&a=storeComment" id="comment-form-' + commentId + '">' +
            '       <input type="hidden" name="video-comment" value="' + text + '">' +
            '       <input type="hidden" name="author" value="' + author + '">' +
            '       <input type="hidden" name="v" value="' + video + '">' +
            '       <input type="hidden" name="reply-to" value="' + commentId + '">' +
            '       <textarea style="resize: none" id="reply-textarea" maxlength="65535" name="video-comment" placeholder="Začnite písať odpoveď..."></textarea>' +
            '       <button type="button" onclick="sendCommentData(document.querySelector(\'form#comment-form-\'' + commentId + '))" class="button">Odoslať</button>' +
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
        '   <form class="video-comment-form" method="post" action="?c=content&a=storeComment" id="comment-form-' + commentId + '">' +
        '       <input type="hidden" name="video-comment" value="' + text + '">' +
        '       <input type="hidden" name="author" value="' + author + '">' +
        '       <input type="hidden" name="v" value="' + video + '">' +
        '       <input type="hidden" name="comment" value="' + commentId + '">' +
        '       <textarea style="resize: none" id="reply-textarea" maxlength="65535" name="video-comment" placeholder="Začnite písať odpoveď...">' + text + '</textarea>' +
        '       <button type="button" onclick="sendCommentData(document.querySelector(\'form#comment-form-\'' + commentId + '))" class="button">Odoslať</button>' +
        '   </form>' +
        '</div>';

    addEventListenerToForm("form#comment-form-" + commentId, "textarea#reply-textarea");
}

function deleteAllCreatedForms(commentId, text, author, video) {
    let editForms = document.querySelectorAll("div.edit-form-container form.video-comment-form");
    let replyForms = document.querySelectorAll("div.reply-form-container");

    // TODO after edit and click on another edit, message disappears (commentId treba inak vymysliet)
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
            sendCommentData(formToSubmit);
        }
    });
}

function sendCommentData(form) {
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
    })
    .then((response) => response.text())
    .then((responseText) => {
        let json = JSON.parse(responseText);

        console.log(json);
        if (json.e != null) {
            window.location.replace("?c=content&a=content&e=" + json.e);
        }

        let commentId = null;
        if (json.commentId == null) {
            commentId = json.comment.id;
        } else {
            commentId = json.commentId;
        }

        let authorInfo = createAuthorInfo(commentId, json.name, json.comment.post_time, json.comment.modification_time, json.comment.author);
        let commentText = createCommentText(commentId, json.comment.text);
        let commentButtons = createCommentButtons(commentId, json.comment.text, json.comment.author, json.name, json.comment.video, json.cookieName, json.cookieId, json.comment.reply_to);
        let commentContainer = createCommentContainer(commentId, json.comment.reply_to, authorInfo, commentText, commentButtons);

        deleteAllCreatedForms(commentId, json.comment.text, json.comment.author, json.comment.video);
    });
}

function deleteComment(videoId, commentId) {
    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        if (xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);

            if (json.e != null) {
                if (json.a != null && json.v != null) {
                    window.location.replace("?c=content&a=" + json.a + "&v=" + json.v + "&e=" + json.e);
                }

                window.location.replace("?c=content&e=" + json.e + "&v=1");
            }

            if (json.comment.reply_to == null) {
                let thread = document.querySelector("div#thread-" + json.comment.id);
                thread.remove();
            } else {
                let replyContainer = document.querySelector("div#reply-to-comment-" + json.comment.reply_to);
                let comment = document.querySelector("div#comment-" + json.comment.id);
                if (replyContainer.childNodes.length - 1 <= 1) {
                    replyContainer.remove();
                } else {
                    comment.remove();
                }
            }
        }
    };

    xhr.open("POST", "http://localhost/vaii-semestralka/?c=content&a=deleteComment", true);
    xhr.setRequestHeader("X-Requested-With", "xmlhttprequest");
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('v=' + videoId + '&comment=' + commentId);
}

function createAuthorInfo(commentId, name, postTime, modificationTime, author) {
    let commentAuthor = null;
    if (modificationTime == null) {
        commentAuthor = document.createElement('div');
        commentAuthor.className = 'comment-author';

        const authorLink = document.createElement('a');
        authorLink.href = '?c=content&a=listContent&uid=' + author;
        authorLink.textContent = name;

        const authorInfo = document.createElement('div');

        const postTimeSpan = document.createElement('span');
        postTimeSpan.textContent = postTime;

        authorInfo.appendChild(postTimeSpan);

        if (modificationTime != null) {
            const editedSpan = document.createElement('span');
            editedSpan.title = modificationTime;
            editedSpan.textContent = ' (Edited)';
            authorInfo.appendChild(editedSpan);
        }

        commentAuthor.appendChild(authorLink);
        commentAuthor.appendChild(authorInfo);
    } else {
        let comment = document.querySelector('div#comment-' + commentId);
        commentAuthor = document.querySelector('div#comment-' + commentId + ' div.comment-author');
        let commentAuthorDiv = document.querySelector('div#comment-' + commentId + ' div.comment-author div');
        console.log(commentAuthor);
        const editedSpan = document.createElement('span');
        editedSpan.title = modificationTime;
        editedSpan.textContent = '(Edited)';
        commentAuthorDiv.appendChild(editedSpan);
        commentAuthor.appendChild(commentAuthorDiv);
        comment.remove();
    }

    return commentAuthor;
}

function createCommentContainer(commentId, replyTo, info, text, buttons) {
    const commentContainer = document.createElement('div');
    commentContainer.classList.add('comment-container');
    if (replyTo != null) {
        commentContainer.classList.add('reply');
        commentContainer.classList.add('r-2');
    }
    commentContainer.id = 'comment-' + commentId;

    commentContainer.appendChild(info);
    commentContainer.appendChild(text);
    if (buttons != null) {
        commentContainer.appendChild(buttons);
    }

    if (replyTo != null) {
        const thread = document.querySelector('div#thread-' + replyTo);
        let replyContainer = document.querySelector('div#reply-to-comment-' + replyTo);
        if (replyContainer == null) {
            replyContainer = document.createElement('div');
            replyContainer.className = 'reply-comment-container';
            replyContainer.id = 'reply-to-comment-' + replyTo;
        }

        replyContainer.appendChild(commentContainer);
        thread.appendChild(replyContainer);
        return thread;
    }

    const commentDiv = document.querySelector('div.commments');
    const commentThread = document.createElement('div');
    commentThread.className = 'thread-comment-container';
    commentThread.id = 'thread-' + commentId;

    commentThread.appendChild(commentContainer);
    commentDiv.appendChild(commentThread);
    return commentDiv;
}

function createCommentText(commentId, text) {
    const commentText = document.createElement('div');
    commentText.className = 'comment-text';
    commentText.id = 'comment-text-' + commentId;

    const commentParagraph = document.createElement('p');
    commentParagraph.textContent = text;

    commentText.appendChild(commentParagraph);

    return commentText;
}

function createCommentButtons(commentId, text, author, authorName, video, cookieAuthorName, cookieAuthorId, replyTo) {
    if (cookieAuthorName === authorName) {
        const commentButtons = document.createElement('div');
        commentButtons.className = 'comment-buttons';

        const editButton = document.createElement('button');
        editButton.type = 'button';
        editButton.className = 'button edit-button';
        editButton.id = 'edit-button-' + commentId;
        editButton.textContent = 'Edit';
        editButton.onclick = function() {
            createEditCommentForm(commentId.toString(), text, author.toString(), video.toString());
        }

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'button delete-button';
        deleteButton.textContent = 'Delete';
        deleteButton.addEventListener('click', () => {
            if (confirm('Naozaj chcete vymazať tento komentár?')) {
                deleteComment(
                    video.toString(),
                    commentId.toString()
                );
            }
        });

        if (replyTo == null) {
            const replyButton = document.createElement('button');
            replyButton.type = 'button';
            replyButton.className = 'button reply-button';
            replyButton.id = 'reply-button-' + commentId;
            replyButton.textContent = 'Reply';
            replyButton.onclick = function() {
                createReplyCommentForm(commentId.toString(), text, cookieAuthorId, video.toString());
            }

            commentButtons.appendChild(replyButton);
        }

        commentButtons.appendChild(editButton);
        commentButtons.appendChild(deleteButton);

        return commentButtons;
    }

    return null;
}

function sendCommentData(data) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.status === 200) {
            console.log("success");
            location.reload();
        }
    }

    xhttp.open("POST", "?c=content&a=storeComment&comment=" + data['comment'] + "&author=" + data['author'] + "&v=" + data['v'] + "&video-comment=" + data['text'], true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send();
}

function editComment(id, author, video) {
    let editableContent = document.querySelectorAll('[contenteditable=true]');
    if (editableContent.length > 0) {
        editableContent.forEach(function(content) {
            content.setAttribute("contenteditable", "false");
            content.classList.remove("editable");
        })
    }

    let comment = document.querySelector("#comment-" + id + " div.comment-text p");
    comment.setAttribute("contenteditable", "true");
    comment.classList.add("editable");
    comment.addEventListener('keydown', function (event) {
            if (event.keyCode === 13 && !event.shiftKey) {
                event.preventDefault();
                sendCommentData({comment: id, author: author, v: video, text: comment.innerHTML});
            }
        }, true);
}
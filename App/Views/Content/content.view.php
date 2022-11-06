<?php
/** @var array $data */
/** @var \App\Core\IAuthenticator $auth */
/** @var Video $video */
/** @var Comment[] $comments */

use App\Models\Comment;
use App\Models\Video;

// TODO ak nie je prihlaseny skus, vyhadzuje error
?>

<div class="main-profile-container">
    <main class="profile-main">
        <?php if (isset($data['error']) && $data['error']) { ?>
            <div>
                <span><?php echo $data['error'] ?></span>
            </div>
        <?php } else { ?>
        <?php
            if (isset($data['video']) && isset($data['comments'])) {
                $video = $data['video'];
                $comments = $data['comments'];
        ?>
        <div class="left-video">
            <div class="video-container">
                <video src="<?php echo $video->getVideo() ?>"></video>
            </div>
            <div class="under-video-container">
                <div class="content-info">
                    <h1 class="video-title" title="<?php echo $video->getTitle() ?>"><?php echo $video->getTitle() ?></h1>
                    <div class="video-info">
                        <div class="video-basic-info">
<!--                            @TODO views mozno odstranit, aj z css-->
                            <span>1000 views</span>
                            <span><?php echo $video->getPostDate() ?></span>
                        </div>
                        <div class="like-dislike-buttons-container">
                            <button type="button" class="button like-button">
                                <img src="public/images/Icons/like.png" alt="Like">
                                <span>100</span>
                            </button>
                            <button type="button" class="button dislike-button">
                                <img src="public/images/Icons/dislike.png" alt="Dislike">
                                <span>100</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="author-description-info">
                    <div class="video-author-container">
                        <div class="video-author">
<!--                            @TODO background image opravit-->
                            <div class="small-profile-image" style="background-image: url('public/images/Bg/login-page-bg-landscape.jpg')">
                                <a href="#"></a>
                            </div>
                            <div class="author-name">
                                <a href="#"><?php echo $video->getAuthorName() ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="video-description">
                        <p><?php echo $video->getDescription() ?></p>
                    </div>
                </div>
            </div>
            <div class="video-comments-container">
                <h2>Pridaj komentár</h2>
                <?php if (!$auth->isLogged()) { ?>
                    <span>Najprv sa musíte prihlásiť.</span>
                <?php } else { ?>
                <form class="video-comment-form" method="post" action="?c=content&a=storeComment">
                    <input type="hidden" name="author" value="<?php echo $auth->getLoggedUserId() ?>">
                    <input type="hidden" name="v" value="<?php echo $video->getId() ?>">
                    <label for="video-comment-input" style="display: none"></label>
                    <textarea name="video-comment" id="video-comment-input" placeholder="Začnite písať komentár..."></textarea>
                    <button type="submit" class="button">Odoslať</button>
                </form>
                <div class="commments">
                    <?php
                    if (count($comments) < 1) {
                        echo "No comments! Be first to comment.";
                    } else {
                        foreach ($comments as $comment) {
                    ?>
                        <div class="comment-container" id="comment-<?php echo $comment->getId() ?>">
                            <div class="comment-author">
                                <a href="#"><?php echo $comment->getAuthorName(); ?></a>
                                <div>
                                    <span> <?php echo $comment->getPostTime(); ?> </span>
                                    <?php
                                    if ($comment->getModificationTime()) { ?>
                                        <span title=<?php echo $comment->getModificationTime(); ?>>(Edited)</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="comment-text">
                                <p><?php echo $comment->getText(); ?></p>
                            </div>
                            <?php if ($auth->isLogged() && $auth->getLoggedUserName() == $comment->getAuthorName()) { ?>
                                <div class="comment-buttons">
                                    <button type="button" class="button"
                                            onclick="editComment(<?php echo $comment->getId() ?>, <?php echo $comment->getAuthor() ?>, <?php echo $video->getId() ?>)">Edit</button>
                                    <button type="button" class="button"
                                            onclick='location.href="?c=content&a=deleteComment&v=<?php echo $video->getId() ?>&comment=<?php echo $comment->getId() ?>"'>Delete</button>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                            $replies = $comment->getReplies();

                            if (isset($replies)) {
                                foreach ($replies as $reply) {
                        ?>
                            <div class="comment-container r-2" id="reply-<?php echo $reply->getId() ?>">
                                <div class="comment-author">
                                    <a href="#"><?php echo $reply->getAuthorName(); ?></a>
                                    <span><?php echo $reply->getPostTime(); ?></span>
                                </div>
                                <div class="comment-text">
                                    <p><?php echo $reply->getText(); ?></p>
                                </div>
                                <?php if ($auth->isLogged() && $auth->getLoggedUserName() == $reply->getAuthorName()) { ?>
                                    <div class="comment-buttons">
                                        <button type="button" class="button">Edit</button>
                                        <button type="button" class="button"
                                                onclick='location.href="?c=content&a=deleteReply&v=<?php echo $video->getId() ?>&reply=<?php echo $reply->getId() ?>"'>Delete</button>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }
                            } ?>
                    <?php }
                    } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="related-videos">
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="public/images/Bg/login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title" title="something">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit
                    </h3>
                    <a href="#" class="video-article-author">
                        Nightcore
                    </a>
                    <span class="video-article-views">
                        183 tis. zhlidanutí
                    </span>
                </div>
            </article>
        </div>
    </main>
</div>
<?php } } ?>
<script>
    function sendCommentData(data) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.status === 200) {
                console.log("success");
            }
        }
        xhttp.open("GET", "?c=content&a=storeComment&ajax=ajax", true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.send(JSON.stringify(data));
    }

    function editComment(id, author, video) {
        let commentContainer = document.querySelector("#comment-" + id + " div.comment-text");
        let comment = document.querySelector("#comment-" + id + " div.comment-text p");

        let form = document.createElement("form");
        let commentTextInput = document.createElement("input");
        let commentIdInput = document.createElement("input");
        let commentAuthorInput = document.createElement("input");
        let commentVideoIdInput = document.createElement("input");
        let commentInputSubmit = document.createElement("button");

        comment.setAttribute("contenteditable", "true");
        comment.classList.add("editable");
        comment.addEventListener('keydown', function (event) {
            if (event.keyCode === 13 && !event.shiftKey) {
                sendCommentData({comment: id, author: author, v: video, text: comment.innerHTML}, {ajax: "ajax"})
        } }, true);

        form.setAttribute("method", "post");
        form.setAttribute("action", "?c=content&a=storeComment");
        form.setAttribute("id", "comment-update");

        commentTextInput.setAttribute("type", "hidden");
        commentIdInput.setAttribute("type", "hidden");
        commentAuthorInput.setAttribute("type", "hidden");
        commentVideoIdInput.setAttribute("type", "hidden");

        commentTextInput.setAttribute("name", "video-comment");
        commentIdInput.setAttribute("name", "comment");
        commentAuthorInput.setAttribute("name", "author");
        commentVideoIdInput.setAttribute("name", "v");

        commentTextInput.setAttribute("value", "This is my first comment. Yaaay!! Edited!!");
        commentIdInput.setAttribute("value", id);
        commentAuthorInput.setAttribute("value", author);
        commentVideoIdInput.setAttribute("value", video);

        commentInputSubmit.setAttribute("type", "submit");
        commentInputSubmit.innerHTML = "Odoslať";
        commentInputSubmit.classList.add("button");

        form.appendChild(commentTextInput);
        form.appendChild(commentInputSubmit);
        form.appendChild(commentIdInput);
        form.appendChild(commentAuthorInput);
        form.appendChild(commentVideoIdInput);
        commentContainer.appendChild(form);
    }
</script>
<script>
    let sidebar = document.querySelector("aside.sidebar");
    let sidebarWidth = getComputedStyle(sidebar).width.split("px")[0];

    sidebar.style.left = sidebarWidth * -1 + "px";
</script>
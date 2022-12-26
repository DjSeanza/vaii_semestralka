<?php
/** @var array $data */
/** @var \App\Core\IAuthenticator $auth */
/** @var Video $video */
/** @var Comment[] $comments */

use App\Models\Comment;
use App\Models\Video;
use App\Models\User;

// TODO ak nie je prihlaseny skus, vyhadzuje error
?>
<div class="main-profile-container">
    <main class="profile-main">
        <?php   if (isset($_GET['e']) && $_GET['e']) {
        ?>
            <div>
                <span>Video nenájdené.</span>
            </div>
        <?php } else { ?>
        <?php
            if (isset($data['video']) && isset($data['comments'])) {
                $video = $data['video'];
                $comments = $data['comments'];
        ?>
        <div class="left-video">
            <div class="video-container">
                <video controls autoplay>
                    <source src="<?php echo $video->getVideo() ?>">
                </video>
            </div>
            <div class="under-video-container">
                <div class="content-info">
                    <h1 class="video-title" title="<?php echo $video->getTitle() ?>"><?php echo $video->getTitle() ?></h1>
                    <div class="video-info">
                        <div class="video-basic-info">
<!--                            @TODO views mozno odstranit, aj z css-->
                            <span><?php echo $video->getViews() ?> views</span>
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
                            <div class="small-profile-image" style='background-image: url("<?php echo User::getOne($auth->getLoggedUserId())->getProfilePicture() ?>")'>
                                <a href="?c=content&a=listContent&uid=<?php echo $video->getAuthor() ?>"></a>
                            </div>
                            <div class="author-name">
                                <a href="?c=content&a=listContent&uid=<?php echo $video->getAuthor() ?>"><?php echo $video->getAuthorName() ?></a>
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
                <form class="video-comment-form" id="video-comment-form" action="?c=content&a=storeComment" method="post">
                    <input type="hidden" name="author" value="<?php echo $auth->getLoggedUserId() ?>">
                    <input type="hidden" name="v" value="<?php echo $video->getId() ?>">
                    <label for="video-comment-input" style="display: none"></label>
                    <textarea maxlength="65535" name="video-comment" id="video-comment-input" placeholder="Začnite písať komentár..."></textarea>
                    <button type="button" onclick="sendCommentData(document.querySelector('form#video-comment-form'))" class="button">Odoslať</button>
                </form>
                <div class="commments">
                    <?php
                    if (count($comments) < 1) {
                        echo "No comments! Be first to comment.";
                    } else {
                        foreach ($comments as $comment) {
                    ?>
                    <div class="thread-comment-container" id="thread-<?php echo $comment->getId() ?>">
                        <div class="comment-container" id="comment-<?php echo $comment->getId() ?>">
                            <div class="comment-author">
                                <a href="?c=content&a=listContent&uid=<?php echo $comment->getAuthor() ?>"><?php echo $comment->getAuthorName(); ?></a>
                                <div>
                                    <span> <?php echo $comment->getPostTime(); ?> </span>
                                    <?php
                                    if ($comment->getModificationTime()) { ?>
                                        <span title="<?php echo $comment->getModificationTime(); ?>">(Edited)</span>
                                    <?php } // end modification time ?>
                                </div>
                            </div>
                            <div class="comment-text" id="comment-text-<?php echo $comment->getId() ?>">
<!--                                TODO po zadani php neukazat container-->
                                <p><?php echo $comment->getText(); ?></p>
                            </div>
                            <?php if ($auth->isLogged() && $auth->getLoggedUserName() == $comment->getAuthorName()) { ?>
                                <div class="comment-buttons">
                                    <button type="button" class="button reply-button" id="reply-button-<?php echo $comment->getId() ?>"
                                            onclick='createReplyCommentForm("<?php echo $comment->getId() ?>", "<?php echo $comment->getText() ?>", "<?php echo $_COOKIE['user']; ?>", "<?php echo $comment->getVideo() ?>")'>Reply</button>
                                    <button type="button" class="button edit-button" id="edit-button-<?php echo $comment->getId() ?>"
                                            onclick='createEditCommentForm("<?php echo $comment->getId() ?>", "<?php echo $comment->getText() ?>", "<?php echo $comment->getAuthor() ?>", "<?php echo $comment->getVideo() ?>")'>Edit</button>
                                    <button type="button" class="button delete-button"
                                            onclick='confirm("Naozaj chcete vymazať tento komentár?") ? deleteComment("<?php echo $comment->getVideo() ?>", "<?php echo $comment->getId() ?>") : ""'>Delete</button>
                                </div>
                            <?php } // end comment buttons ?>
                        </div> <!-- /comment container -->
                            <div class="reply-comment-container" id="reply-to-comment-<?php echo $comment->getId() ?>">
                        <?php
                            $replies = $comment->getReplies();

                            if (isset($replies)) {
                                foreach ($replies as $reply) {
                        ?>
                            <div class="comment-container reply r-2" id="comment-<?php echo $reply->getId() ?>">
                                <div class="comment-author">
                                    <a href="?c=content&a=listContent&uid=<?php echo $reply->getAuthor() ?>"><?php echo $reply->getAuthorName(); ?></a>
                                    <div>
                                        <span><?php echo $reply->getPostTime(); ?></span>
                                        <?php
                                        if ($reply->getModificationTime()) { ?>
                                            <span title="<?php echo $reply->getModificationTime(); ?>">(Edited)</span>
                                        <?php } // end modification time ?>
                                    </div>
                                </div>
                                <div class="comment-text" id="comment-text-<?php echo $reply->getId() ?>">
                                    <p><?php echo $reply->getText(); ?></p>
                                </div>
                                <?php if ($auth->isLogged() && $auth->getLoggedUserName() == $reply->getAuthorName()) { ?>
                                    <div class="comment-buttons">
                                        <button type="button" class="button edit-button" id="reply-button-<?php echo $reply->getId() ?>"
                                                onclick='createEditCommentForm("<?php echo $reply->getId() ?>", "<?php echo $reply->getText() ?>", "<?php echo $reply->getAuthor() ?>", "<?php echo $reply->getVideo() ?>")'>Edit</button>
                                        <button type="button" class="button delete-button" id="edit-button-<?php echo $reply->getId() ?>"
                                                onclick='confirm("Naozaj chcete vymazať tento komentár?") ? deleteComment("<?php echo $reply->getVideo() ?>", "<?php echo $reply->getId() ?>") : ""'>Delete</button>
                                    </div>
                                <?php } // end comment buttons ?>
                            </div> <!-- /comment container -->
                        <?php } // end foreach replies
                            } // end if isset replies ?>
                        </div> <!-- /reply comment container -->
                    </div>
                    <?php } // end foreach comments
                    } // end else if comments > 1 ?>
                </div>
                <?php } // end if user logged  ?>
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
<script src="public/js/ajax/comments/comments.js"></script>
<script>
    let sidebar = document.querySelector("aside.sidebar");
    let sidebarWidth = getComputedStyle(sidebar).width.split("px")[0];

    sidebar.style.left = sidebarWidth * -1 + "px";
    sidebar.style.display = "none";
</script>
<script>
    addEventListenerToForm("form#video-comment-form", "textarea#video-comment-input");
</script>
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
                <form class="video-comment-form" id="video-comment-form" method="post" action="?c=content&a=storeComment">
                    <input type="hidden" name="author" value="<?php echo $auth->getLoggedUserId() ?>">
                    <input type="hidden" name="v" value="<?php echo $video->getId() ?>">
                    <label for="video-comment-input" style="display: none"></label>
                    <textarea maxlength="65535" name="video-comment" id="video-comment-input" placeholder="Začnite písať komentár..."></textarea>
                    <button type="submit" class="button">Odoslať</button>
                </form>
                <div class="commments">
                    <?php
                    if (count($comments) < 1) {
                        echo "No comments! Be first to comment.";
                    } else {
                        foreach ($comments as $comment) {
                    ?>
                    <div class="thread-comment-container">
                        <div class="comment-container" id="comment-<?php echo $comment->getId() ?>">
                            <div class="comment-author">
                                <a href="#"><?php echo $comment->getAuthorName(); ?></a>
                                <div>
                                    <span> <?php echo $comment->getPostTime(); ?> </span>
                                    <?php
                                    if ($comment->getModificationTime()) { ?>
                                        <span title="<?php echo $comment->getModificationTime(); ?>">(Edited)</span>
                                    <?php } // end modification time ?>
                                </div>
                            </div>
                            <div class="comment-text" id="comment-text-<?php echo $comment->getId() ?>">
                                <p><?php echo $comment->getText(); ?></p>
                            </div>
                            <?php if ($auth->isLogged() && $auth->getLoggedUserName() == $comment->getAuthorName()) { ?>
                                <div class="comment-buttons">
                                    <button type="button" class="button reply-button"
                                            onclick='createReplyCommentForm("<?php echo $comment->getId() ?>", "<?php echo $comment->getText() ?>", "<?php echo $_COOKIE['user']; ?>", "<?php echo $comment->getVideo() ?>")'>Reply</button>
                                    <button type="button" class="button edit-button"
                                            onclick='createEditCommentForm("<?php echo $comment->getId() ?>", "<?php echo $comment->getText() ?>", "<?php echo $comment->getAuthor() ?>", "<?php echo $comment->getVideo() ?>")'>Edit</button>
                                    <button type="button" class="button delete-button"
                                            onclick='location.href="?c=content&a=deleteComment&v=<?php echo $video->getId() ?>&comment=<?php echo $comment->getId() ?>"'>Delete</button>
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
                                    <a href="#"><?php echo $reply->getAuthorName(); ?></a>
                                    <div>
                                        <span><?php echo $reply->getPostTime(); ?></span>
                                        <?php
                                        if ($reply->getModificationTime()) { ?>
                                            <span title="<?php echo $comment->getModificationTime(); ?>">(Edited)</span>
                                        <?php } // end modification time ?>
                                    </div>
                                </div>
                                <div class="comment-text" id="comment-text-<?php echo $reply->getId() ?>">
                                    <p><?php echo $reply->getText(); ?></p>
                                </div>
                                <?php if ($auth->isLogged() && $auth->getLoggedUserName() == $reply->getAuthorName()) { ?>
                                    <div class="comment-buttons">
                                        <button type="button" class="button edit-button"
                                                onclick='createEditCommentForm("<?php echo $reply->getId() ?>", "<?php echo $reply->getText() ?>", "<?php echo $reply->getAuthor() ?>", "<?php echo $reply->getVideo() ?>")'>Edit</button>
                                        <button type="button" class="button delete-button"
                                                onclick='location.href="?c=content&a=deleteComment&v=<?php echo $video->getId() ?>&comment=<?php echo $reply->getId() ?>"'>Delete</button>
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
<script src="public/js/comments/updateComment.js"></script>
<script src="public/js/comments/createCommentForm.js"></script>
<script>
    let sidebar = document.querySelector("aside.sidebar");
    let sidebarWidth = getComputedStyle(sidebar).width.split("px")[0];

    sidebar.style.left = sidebarWidth * -1 + "px";
    sidebar.style.display = "none";
</script>
<script>
    addEventListenerToForm("form#video-comment-form", "textarea#video-comment-input");
</script>

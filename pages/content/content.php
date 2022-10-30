<?php
require "../../paths.php";
require "../../components/head.php";
require "../../components/header/header.php";
?>

<div class="main-profile-container">
    <div class="profile-sidebar">
        <?php require "../../components/sidebar/sidebar.php"; ?>
    </div>
    <main class="profile-main">
        <div class="left-video">
            <div class="video-container">
                <video src="#"></video>
            </div>
            <div class="under-video-container">
                <div class="content-info">
                    <h1 class="video-title" title="Video - Video title inserted here">Video - Video title inserted here</h1>
                    <div class="video-info">
                        <div class="video-basic-info">
                            <span>1000 views</span>
                            <span>10. 9. 2022</span>
                        </div>
                        <div class="like-dislike-buttons-container">
                            <button type="button" class="button like-button">
                                <img src="<?php echo ROOT_PATH; ?>img/like.png" alt="Like">
                                <span>100</span>
                            </button>
                            <button type="button" class="button dislike-button">
                                <img src="<?php echo ROOT_PATH; ?>img/dislike.png" alt="Dislike">
                                <span>100</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="author-description-info">
                    <div class="video-author-container">
                        <div class="video-author">
                            <div class="small-profile-image" style="background-image: url('<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg')">
                                <a href="#"></a>
                            </div>
                            <div class="author-name">
                                <a href="#">Author name here</a>
                            </div>
                        </div>
                    </div>
                    <div class="video-description">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores blanditiis eum itaque iure, quod sunt velit. Adipisci asperiores assumenda consequuntur culpa enim, maxime minus molestiae molestias quis sequi tempora voluptates.</p>
                    </div>
                </div>
            </div>
            <div class="video-comments-container">
                <h2>Pridaj komentár</h2>
                <form class="video-comment-form" action="#">
                    <label for="video-comment-input" style="display: none"></label>
                    <textarea name="video-comment" id="video-comment-input" placeholder="Začnite písať komentár..."></textarea>
                </form>
                <div class="commments">
                    <div class="comment-container">
                        <div class="comment-author">
                            <a href="#">Komentátor</a>
                            <span>pred 2 rokmi</span>
                        </div>
                        <div class="comment-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, maxime minima. Assumenda corporis cumque doloremque doloribus expedita harum hic illo inventore iste laudantium nesciunt, officiis perspiciatis possimus tempora tempore voluptates.</p>
                        </div>
                    </div>
                    <div class="comment-container r-2">
                        <div class="comment-author">
                            <a href="#">Komentátor</a>
                            <span>pred 2 rokmi</span>
                        </div>
                        <div class="comment-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, maxime minima. Assumenda corporis cumque doloremque doloribus expedita harum hic illo inventore iste laudantium nesciunt, officiis perspiciatis possimus tempora tempore voluptates.</p>
                        </div>
                    </div>
                    <div class="comment-container r-3">
                        <div class="comment-author">
                            <a href="#">Komentátor</a>
                            <span>pred 2 rokmi</span>
                        </div>
                        <div class="comment-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, maxime minima. Assumenda corporis cumque doloremque doloribus expedita harum hic illo inventore iste laudantium nesciunt, officiis perspiciatis possimus tempora tempore voluptates.</p>
                        </div>
                    </div>
                    <div class="comment-container r-2">
                        <div class="comment-author">
                            <a href="#">Komentátor</a>
                            <span>pred 2 rokmi</span>
                        </div>
                        <div class="comment-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, maxime minima. Assumenda corporis cumque doloremque doloribus expedita harum hic illo inventore iste laudantium nesciunt, officiis perspiciatis possimus tempora tempore voluptates.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="related-videos">
            <article class="video-article-container related-videos-video-container">
                <div class="video-thumbnail">
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
                    <img src="<?php echo ROOT_PATH; ?>img/login-page-bg-landscape.jpg" alt="">
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
<script>
    let sidebar = document.querySelector("aside.sidebar");
    let sidebarWidth = getComputedStyle(sidebar).width.split("px")[0];

    sidebar.style.left = sidebarWidth * -1 + "px";
</script>

<?php
require "../../components/page-ending.php";
?>


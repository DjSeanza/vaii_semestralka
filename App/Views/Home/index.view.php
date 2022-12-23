<?php
/** @var array $data */
/** @var Video[] $generatedVideos */
/** @var Video[] $latestVideos */

use App\Models\Video;

?>

<main class="main sidebar-responsive-main">
    <section class="home-page-section">
        <h2>Kategórie</h2>
        <div class="home-page-video-container">
            <article class="video-article-container" onclick='location.href="?c=content&a=content&v=1"'>
                <div class="video-thumbnail">
                    <img src="public/images/Bg//login-page-bg-landscape.jpg" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title">
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
    </section>
    <section class="home-page-section">
        <h2>Najnovšie</h2>
        <div class="home-page-video-container">
            <?php if(isset($data['latestVideos'])) {
                $latestVideos = $data['latestVideos'];

                foreach ($latestVideos as $lastVideo) {
            ?>
            <article class="video-article-container" onclick='location.href="?c=content&a=content&v="<?php echo $lastVideo->getId() ?>'>
                <div class="video-thumbnail">
                    <img src="<?php echo $lastVideo->getThumbnail() ?>" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title">
                        <?php echo $lastVideo->getTitle() ?>
                    </h3>
                    <a href="#" class="video-article-author">
                        <?php echo $lastVideo->getAuthorName() ?>
                    </a>
                    <span class="video-article-views">
                        <?php echo $lastVideo->getViews() ?> zhliadnutí
                    </span>
                </div>
            </article>
            <?php } } ?>
        </div>
    </section>
    <section class="home-page-section">
        <h2>Top Videá</h2>
        <div class="home-page-video-container">
            <?php if(isset($data['topVideos'])) {
                $topVideos = $data['topVideos'];

                foreach ($topVideos as $topVideo) {
                    ?>
                    <article class="video-article-container" onclick='location.href="?c=content&a=content&v="<?php echo $topVideo->getId() ?>'>
                        <div class="video-thumbnail">
                            <img src="<?php echo $topVideo->getThumbnail() ?>" alt="">
                        </div>
                        <div class="video-article-details">
                            <h3 class="video-article-title">
                                <?php echo $topVideo->getTitle() ?>
                            </h3>
                            <a href="#" class="video-article-author">
                                <?php echo $topVideo->getAuthorName() ?>
                            </a>
                            <span class="video-article-views">
                        <?php echo $topVideo->getViews() ?> zhliadnutí
                    </span>
                        </div>
                    </article>
                <?php } } ?>
        </div>
    </section>
    <section class="home-page-section">
        <div class="videos-container" id="generated-videos">
            <?php if (isset($data['generatedVideos'])) {
                $generatedVideos = $data['generatedVideos'];

                foreach ($generatedVideos as $generatedVideo) {
            ?>
            <article class="video-article-container" onclick='location.href="?c=content&a=content&v="<?php echo $generatedVideo->getId() ?>'>
                <div class="video-thumbnail">
                    <img src="<?php echo $generatedVideo->getThumbnail() ?>" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title">
                        <?php echo $generatedVideo->getTitle() ?>
                    </h3>
                    <a href="#" class="video-article-author">
                        <?php echo $generatedVideo->getAuthorName(); ?>
                    </a>
                    <span class="video-article-views">
                        <?php echo $generatedVideo->getViews() ?> zhlidanutí
                    </span>
                </div>
            </article>
            <?php } } ?>
        </div>
    </section>

</main>
<script src="public/js/ajax/landingPage/landingPageDynamicContent.js"></script>
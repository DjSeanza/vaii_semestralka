<?php
/** @var array $data */
/** @var Video[] $generatedVideos */
/** @var Video[] $latestVideos */
/** @var Video[] $topVideos */
/** @var Category[] $categories */

use App\Models\Category;
use App\Models\Video;

?>
<main class="main sidebar-responsive-main">
    <section class="home-page-section">
        <div class="home-page-video-container category-container">
            <?php if(isset($data['categories'])) {
            $categories = $data['categories'];

            foreach ($categories as $category) {
            ?>
            <div class="category-name-container" onclick="location.href='?c=content&a=listContent&cat=<?php echo $category->getId() ?>'">
                <span class="category-name"><?php echo $category->getCategoryName() ?></span>
            </div>
            <?php } } ?>
        </div>
    </section>
    <section class="home-page-section">
        <h2>Najnovšie</h2>
        <div class="home-page-video-container">
            <?php if(isset($data['latestVideos'])) {
                $latestVideos = $data['latestVideos'];

                foreach ($latestVideos as $lastVideo) {
            ?>
            <article class="video-article-container" onclick='location.href="?c=content&a=content&v=<?php echo $lastVideo->getId() ?>"'>
                <div class="video-thumbnail">
                    <img src="<?php echo $lastVideo->getThumbnail() ?>" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title">
                        <?php echo $lastVideo->getTitle() ?>
                    </h3>
                    <a href="?c=content&a=listContent&uid=<?php echo $lastVideo->getAuthor() ?>" class="video-article-author">
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
                    <article class="video-article-container" onclick='location.href="?c=content&a=content&v=<?php echo $topVideo->getId() ?>"'>
                        <div class="video-thumbnail">
                            <img src="<?php echo $topVideo->getThumbnail() ?>" alt="">
                        </div>
                        <div class="video-article-details">
                            <h3 class="video-article-title">
                                <?php echo $topVideo->getTitle() ?>
                            </h3>
                            <a href="?c=content&a=listContent&uid=<?php echo $topVideo->getAuthor() ?>" class="video-article-author">
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
            <article class="video-article-container" onclick='location.href="?c=content&a=content&v=<?php echo $generatedVideo->getId() ?>"'>
                <div class="video-thumbnail">
                    <img src="<?php echo $generatedVideo->getThumbnail() ?>" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title">
                        <?php echo $generatedVideo->getTitle() ?>
                    </h3>
                    <a href="?c=content&a=listContent&uid=<?php echo $generatedVideo->getAuthor() ?>" class="video-article-author">
                        <?php echo $generatedVideo->getAuthorName(); ?>
                    </a>
                    <span class="video-article-views">
                        <?php echo $generatedVideo->getViews() ?> zhliadnutí
                    </span>
                </div>
            </article>
            <?php } } ?>
        </div>
    </section>

</main>
<script src="public/js/createVideoContainer/createVideoContainer.js"></script>
<script src="public/js/ajax/landingPage/landingPageDynamicContent.js"></script>
<script>
    let categories = document.querySelectorAll("span.category-name");
    let container = document.querySelectorAll("div.category-name-container");

    for (let i = 0; i < categories.length; i++) {
        container[i].style.width = categories[i].getBoundingClientRect().width + "px";
    }
</script>
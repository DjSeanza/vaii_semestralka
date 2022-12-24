<?php
/** @var array $data */
/** @var Video[] $videos */

use App\Models\Video;
?>

<div class="main-container">
    <main class="main sidebar-responsive-main video-main">
        <?php
        if (isset($_GET['e'])) {
            ?>
            <span>Nepodarilo sa načítať.</span>
        <?php } else {
            if (isset($data['name']) && isset($data['videos'])) {
                $videos = $data['videos'];
        ?>
        <h1 class="videos-h1"><?php echo $data['name'] ?></h1>
        <div class="videos-container">
            <?php foreach ($videos as $video) { ?>
            <article class="video-article-container video-page">
                <div class="video-thumbnail">
                    <img src="<?php echo $video->getThumbnail() ?>" alt="">
                </div>
                <div class="video-article-details">
                    <h3 class="video-article-title">
                        <?php echo $video->getTitle() ?>
                    </h3>
                    <a href="?c=content&a=listContent&uid=<?php echo $video->getAuthor() ?>" class="video-article-author">
                        <?php echo $video->getAuthorName() ?>
                    </a>
                    <span class="video-article-views">
                        <?php echo $video->getViews() ?> zhliadnutí
                    </span>
                </div>
            </article>
            <?php } } } ?>
        </div>
    </main>
</div>

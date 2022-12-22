<?php
/** @var \App\Core\IAuthenticator $auth */
/** @var array $data */

$videos = null;
if ($data) {
    $videos = $data['videos'];
}

?>

<div class="main-settings-container">
    <main class="main">
        <?php if (!$videos) { ?>
            <span>Nemáte nahraté žiadne videá.</span>
        <?php } else { ?>
        <div class="content-container">
            <button class="add-content-button button" onclick="location.href='?c=studio&a=formContent'">Add</button>
            <ul class="content-ul">
                <?php foreach ($videos as $video) { ?>
                    <li class="content-article-container">
                        <div class="content-article-image">
                            <img src="<?php echo $video->getThumbnail() ?>" alt="Content Image">
                        </div>
                        <div class="content-article-info">
                            <span class="content-title" title="<?php echo $video->getTitle() ?>"><?php echo $video->getTitle() ?></span>
                            <div class="content-article-detail">
                                <div>
                                    <span class="content-article-detail-views"><?php echo $video->getViews() ?> zhliadnutí</span>
                                </div>
                                <div>
    <!--                                 TODO dorobit likes-->
                                    <span class="content-article-detail-likes">Likes: 3000</span>
                                    <span class="content-article-detail-dislikes">Dislikes: 2500</span>
                                </div>
                            </div>
                        </div>
                        <div class="content-article-controls">
                            <button class="content-article-control-button button edit-button" onclick="location.href='?c=studio&a=formContent&cid=<?php echo $video->getId() ?>'">Edit</button>
                            <button class="content-article-control-button button delete-button" onclick="confirmDelete('<?php echo $video->getTitle() ?>', <?php echo $video->getId() ?>)">Delete</button>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </main>
</div>

<script>
    function confirmDelete(title, id) {
        if (confirm('Skutočne chcete odstrániť video: ' + title + '?'))
          location.href='?c=studio&a=deleteContent&cid=' + id;
    }
</script>

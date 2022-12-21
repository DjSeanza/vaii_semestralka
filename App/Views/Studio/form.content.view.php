<?php
use App\Models\Category;

/** @var Category[] $categories */
/** @var \App\Core\IAuthenticator $auth */
/** @var array $data */
/** @var \App\Models\Video $video */

$video = null;
if (isset($data['video']) && $data['video']) {
    $video = $data['video'];
}
?>

<main class="main">
    <form action="?c=studio&a=storeContent" method="post" enctype="multipart/form-data">
        <label for="title">
            <h2>Názov</h2>
            <input type="text" name="title" id="title" minlength="1" maxlength="255" required value="<?php if($video) echo $video->getTitle(); ?>">
        </label>
        <label for="description">
            <h2>Popis</h2>
            <textarea name="description" id="title" minlength="1" maxlength="65535" required style="resize: none"><?php if($video) echo $video->getDescription(); ?></textarea>
        </label>
        <label for="thumbnail">
            <h2>Thumbnail</h2>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg, image/jpg, image/png, image/svg, image/webp" <?php if(!$video) echo "required"; ?>>
        </label>
        <label for="category">
            <h2>Kategória</h2>
            <select name="category" id="category">
                <?php if($video) { ?>
                    <option value="<?php echo $video->getCategory(); ?>" selected><?php try {
                                                                                        echo $video->getCategoryName();
                                                                                    } catch (Exception $e) {
                                                                                        throw new \Exception('Category not found: ' . $e->getMessage(), 0, $e);
                                                                                    } ?>
                    </option>
                <?php } else { ?>
                    <option selected disabled></option>
                <?php } ?>
                <?php
                try {
                    $categories = Category::getAll();
                } catch (Exception $e) {
                    echo $e;
                }
                foreach ($categories as $category) {
                ?>
                <option value="<?php echo $category->getId(); ?>"><?php echo $category->getCategoryName(); ?></option>
                <?php } ?>
            </select>
        </label>
        <label for="content">
            <h2>Video</h2>
            <input type="file" name="content" id="content" accept="application/mp4" <?php if(!$video) echo "required"; ?>>
        </label>
        <?php
            if (isset($_GET['cid'])) {
        ?>
                <input type="hidden" value="<?php echo $_GET['cid'] ?>" name="cid">
        <?php } ?>
        <input type="hidden" value="<?php echo $auth->getLoggedUserId(); ?>" name="uid">
        <button type="submit">Odoslať</button>
    </form>
</main>
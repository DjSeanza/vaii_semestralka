<?php
use App\Models\Category;

/** @var Category $category */
/** @var array $data */

$category = null;
if (isset($data['category']) && $data['category']) {
    $category = $data['category'];
}
?>

<main class="main">
    <form action="?c=category&a=storeCategory" method="post">
        <label for="categoryName">
            <h2>Názov</h2>
            <input type="text" name="categoryName" id="categoryName" minlength="1" maxlength="20" required value="<?php if($category) echo $category->getCategoryName(); ?>">
            <?php if ($category) { ?>
            <input type="hidden" name="cid" value="<?php echo $category->getId() ?>">
            <?php } ?>
        </label>
        <button type="submit">Odoslať</button>
    </form>
</main>
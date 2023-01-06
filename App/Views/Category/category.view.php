<?php
/** @var \App\Core\IAuthenticator $auth */
/** @var array $data */
/** @var \App\Models\Category[] $categories */

$categories = null;
if ($data) {
    $categories = $data['categories'];
}

?>

<div class="main-settings-container">
    <main class="main">
        <?php if (!$categories) { ?>
            <span>Neexistujú žiadne kategórie.</span>
        <?php } else { ?>
        <div class="content-container">
            <button class="add-content-button button" onclick="location.href='?c=category&a=formCategory'">Add</button>
            <ul class="content-ul">
                <?php foreach ($categories as $category) { ?>
                    <li class="category-list-item">
                        <span class="category-list-name"><?php echo $category->getCategoryName() ?></span>
                        <div class="content-article-controls">
                            <button class="content-article-control-button button edit-button" onclick="location.href='?c=category&a=formCategory&cid=<?php echo $category->getId() ?>'">Edit</button>
                            <button class="content-article-control-button button delete-button" onclick="confirmDelete('<?php echo $category->getCategoryName() ?>', <?php echo $category->getId() ?>)">Delete</button>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
    </main>
</div>

<script>
    function confirmDelete(name, id) {
        if (confirm('Skutočne chcete odstrániť kategóriu: ' + name + '?'))
          location.href='?c=category&a=deleteCategory&cid=' + id;
    }
</script>

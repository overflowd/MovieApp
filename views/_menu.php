<?php
if (isset($_GET["categoryid"]) and is_numeric($_GET["categoryid"])) {
    $selectedCategory = $_GET["categoryid"];
}
?>

<ul class="list-group">
    <a href='blogs.php' class="list-group-item list-group-item-action">Tüm Kategoriler</a>
    <?php $result = getCategories();
    while ($kategori = mysqli_fetch_assoc($result)): ?>
        <?php if ($kategori["isActive"]): ?>
            <a href='<?php echo "blogs.php?categoryid=" . $kategori["id"] ?>' class="list-group-item list-group-item-action
            <?php
            if ($kategori["id"] == $selectedCategory) {
                echo "active";
            }
            ?>">
                <?php echo ucfirst($kategori["name"]) ?>
            </a>
        <?php endif; ?>
    <?php endwhile; ?>
</ul>
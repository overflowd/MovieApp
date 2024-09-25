<?php
require("libs/vars.php");
require("libs/functions.php");

$id = $_GET["id"];
$result = getBlogById($id);
$selectedMovie = mysqli_fetch_assoc($result);

$categories = getCategories();
$selectedCategories = getCategoriesByBlogId($id);

if (isset($_POST["edit"])) {
    $filmBaslik = control_input($_POST["title"]);
    $filmAciklama = control_input($_POST["description"]);
    $filmResim = control_input($_POST["imageUrl"]);
    $filmUrl = control_input($_POST["url"]);
    $filmKategoriler = $_POST["categories"];
    $filmVizyon = isset($_POST["isActive"]) ? 1 : 0;

    if (editBlog($id, $filmBaslik, $filmAciklama, $filmResim, $filmUrl, $filmVizyon)) {
        clearBlogCategories($id);
        if(count($filmKategoriler)>0){
            addBlogToCategories($id,$filmKategoriler);
        }
        $_SESSION["message"] = $filmBaslik . " isimli blog güncellendi.";
        $_SESSION["type"] = "success";
        header("Location: admin-blogs.php");
    } else {
        echo "hata: ";
    }
}

?>

<?php include("views/_header.php"); ?>
<?php include("views/_navbar.php"); ?>

<div class="container my-3">
    <div class="card">
        <div class="card-body">
            <form method="POST">
                <div class="row">
                    <div class="col-9">
                        <div id="edit-form">
                            <div class="mb-3">
                                <label for="title" class="form-label">Başlık</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo $selectedMovie["title"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Açıklama</label>
                                <textarea name="description" id="description" class="form-control"><?php echo $selectedMovie["description"] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="imageUrl" class="form-label">Resim</label>
                                <input type="text" class="form-control" name="imageUrl" id="imageUrl" value="<?php echo $selectedMovie["imageUrl"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">Url</label>
                                <input type="text" class="form-control" name="url" id="url" value="<?php echo $selectedMovie["url"] ?>">
                            </div>
                            <div class="form-check mb-3">
                                <label for="filmUrl" class="form-check-label">Vizyonda</label>
                                <input type="checkbox" class="form-check-input" name="isActive" id="isActive" <?php if ($selectedMovie["isActive"]) {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
                            </div>
                            <input type="submit" name="edit" value="Güncelle" class="btn btn-primary">
                        </div>
                    </div>
                    <div class="col-3">
                        <?php foreach ($categories as $c): ?>
                            <div class="form-check">
                                <label for="category_<?php echo $c["id"]; ?>"><?php echo $c["name"]; ?></label>
                                <input type="checkbox" name="categories[]"
                                    id="category_<?php echo $c["id"]; ?>"
                                    class="form-check-input"
                                    value="<?php echo $c["id"]; ?>"
                                    <?php $isChecked = false;
                                    foreach ($selectedCategories as $s) {
                                        if ($s["id"] == $c["id"]) {
                                            $isChecked = true;
                                        }
                                    }

                                    if ($isChecked) {
                                        echo "checked";
                                    }
                                    ?>>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("views/_ckeditor.php"); ?>
<?php include("views/_footer.php"); ?>
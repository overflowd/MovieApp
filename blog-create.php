<?php
require("libs/vars.php");
require("libs/functions.php");

$title = $description = $category = $imageUrl = $url = "";
$title_err = $description_err = $category_err = $imageUrl_err = $url_err = "";

$categories = getCategories();

if (isset($_POST["create"])) {

    $input_title = trim($_POST["title"]);

    if (empty($input_title)) {
        $title_err = "title boş geçilemez.";
    } else if (strlen($input_title) > 150) {
        $title_err = "title için karakter sınırını geçtiniz.";
    } else {
        $title = control_input($input_title);
    }

    $input_description = trim($_POST["description"]);

    if (empty($input_description)) {
        $description_err = "description boş geçilemez.";
    } else if (strlen($input_description) < 10) {
        $description_err = "description için çok az karakter girdiniz.";
    } else {
        $description = control_input($input_description);
    }

    $input_category = $_POST["category"];

    if ($input_category == "0") {
        $category_err = "kategori seçmelisiniz.";
    } else {
        $category = control_input($input_category);
    }

    $input_imageUrl = trim($_POST["imageUrl"]);

    if (empty($input_imageUrl)) {
        $imageUrl_err = "imageUrl boş geçilemez.";
    } else if (strlen($input_imageUrl) > 100) {
        $imageUrl_err = "imageUrl için karakter sınırını geçtiniz.";
    } else {
        $imageUrl = control_input($input_imageUrl);
    }

    $input_url = trim($_POST["url"]);

    if (empty($input_url)) {
        $url_err = "url boş geçilemez.";
    } else if (strlen($input_url) > 150) {
        $url_err = "url için karakter sınırını geçtiniz.";
    } else {
        $url = control_input($input_url);
    }

    if (empty($title_err) and empty($description_err) and empty($imageUrl_err) and empty($url_err) and empty($category_err)) {
        if (createBlog($title, $description, $imageUrl, $url, $category)) {
            $_SESSION["message"] = $title . " isimli blog eklendi.";
            $_SESSION["type"] = "success";
            header("Location: admin-blogs.php");
        } else {
            echo "hata: ";
        }
    }
}

?>

<?php include("views/_header.php"); ?>
<?php include("views/_navbar.php"); ?>

<div class="container my-3">
    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-body">
                    <form action="blog-create.php" method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Başlık</label>
                            <input type="text" name="title" id="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : '' ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea name="description" id="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : '' ?>"><?php echo $description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="imageUrl" class="form-label">Resim</label>
                            <input type="text" name="imageUrl" id="imageUrl" class="form-control <?php echo (!empty($imageUrl_err)) ? 'is-invalid' : '' ?>">
                            <span class="invalid-feedback"><?php echo $imageUrl_err ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" name="url" id="url" class="form-control <?php echo (!empty($url_err)) ? 'is-invalid' : '' ?>">
                            <span class="invalid-feedback"><?php echo $url_err ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select <?php echo (!empty($description_err)) ? 'is-invalid' : '' ?>">
                                <option selected value="0">Seçiniz</option>
                                <?php foreach ($categories as $c) {
                                    echo "<option value='{$c['id']}'>{$c["name"]}</option>";
                                }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $category_err ?></span>
                            <script type="text/javascript">
                                document.getElementById("category").value = "<?php echo $category ?>"
                            </script>
                        </div>
                        <input type="submit" name="create" value="Film Ekle" class="btn btn-primary">
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>

<?php include("views/_ckeditor.php"); ?>
<?php include("views/_footer.php"); ?>
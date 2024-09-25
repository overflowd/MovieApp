<?php
require("libs/vars.php");
require("libs/functions.php");

$categoryName = "";
$categoryName_err = "";

if (isset($_POST["create"])) {

    $input_categoryName = trim($_POST["categoryName"]);

    if (empty($input_categoryName)) {
        $categoryName_err = "categoryName boş geçilemez.";
    } else if (strlen($input_categoryName) > 100) {
        $categoryName_err = "categoryName için karakter sınırını geçtiniz.";
    } else {
        $categoryName = control_input($input_categoryName);
    }

    if (empty($categoryName_err)) {
        if (createCategory($categoryName)) {
            $_SESSION["message"] = $categoryName . " isimli category eklendi.";
            $_SESSION["type"] = "success";
            header("Location: admin-categories.php");
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
                    <form action="category-create.php" method="POST">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Kategori İsmi</label>
                            <input type="text" name="categoryName" id="categoryName" class="form-control <?php echo (!empty($categoryName_err)) ? 'is-invalid' : '' ?>">
                            <span class="invalid-feedback"><?php echo $categoryName_err ?></span>
                        </div>
                        <input type="submit" name="create" value="Kategori Ekle" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("views/_footer.php"); ?>
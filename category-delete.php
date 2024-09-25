<?php
require("libs/vars.php");
require "libs/functions.php";

$id = $_GET["id"];
$result = getCategoryById($id);
$categoryName=mysqli_fetch_array($result)["name"];

if(deleteCategory($id)){
    $_SESSION["message"] =  $categoryName . " isimli kategori silindi.";
    $_SESSION["type"] = "";

    header("Location: admin-categories.php");
} else {
    echo "hata: ";
}



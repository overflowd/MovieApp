<?php
require("libs/vars.php");
require "libs/functions.php";

$id = $_GET["id"];
$result = getBlogById($id);
$title=mysqli_fetch_array($result)["title"];

if(deleteBlog($id)){
    $_SESSION["message"] =  $title . " isimli blog silindi.";
    $_SESSION["type"] = "";

    header("Location: admin-blogs.php");
} else {
    echo "hata: ";
}



<?php
$resultCategories=getCategories();
$resultBlogs=getBlogs();
$categories=[];
$blogs=[];
while($row=mysqli_fetch_assoc($resultCategories)){
    array_push($categories,$row);
}
while($row=mysqli_fetch_assoc($resultBlogs)){
    array_push($blogs,$row);
}
$ozet = count($categories) . " kategoride " . count($blogs) . " adet film listelenmiştir.";
?>

<h1 class="mb-4"><?php echo baslik ?></h1>
<p class="text-muted">
    <?php echo $ozet ?>
</p>
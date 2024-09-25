<?php 
setcookie("auth[username]","",time()-3600);
setcookie("auth[name]","",time()-3600);
header("Location: index.php");
?>
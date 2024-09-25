<?php

function createBlog(string $baslik, string $aciklama, string $resim, string $url, int $category, int $isActive = 0)
{
    include "ayar.php";
    $query = "INSERT INTO blogs(title, description, imageUrl, url, category_id , isActive) VALUES (?,?,?,?,?,?)";
    $result = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($result, 'ssssii', $baslik, $aciklama, $resim, $url, $category, $isActive);
    mysqli_stmt_execute($result);
    mysqli_stmt_close($result);
    mysqli_close($connection);
    return $result;
}

function getBlogs()
{
    include "ayar.php";
    $query = "SELECT * FROM blogs";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;
}

function getCategories()
{
    include "ayar.php";
    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;
}

function getBlogById(int $id)
{
    include "ayar.php";
    $query = "SELECT * FROM blogs WHERE id='$id' ";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;
}

function editBlog(int $id, string $filmBaslik, string $filmAciklama, string $filmResim, string $filmUrl, bool $filmVizyon)
{
    include "ayar.php";
    $query = "UPDATE blogs SET title='$filmBaslik', description='$filmAciklama', imageUrl='$filmResim', url='$filmUrl', isActive='$filmVizyon' WHERE id='$id' ";
    $result = mysqli_query($connection, $query);
    return $result;
}

function deleteBlog(int $id)
{
    include "ayar.php";
    $query = "DELETE FROM blogs WHERE id='$id' ";
    $result = mysqli_query($connection, $query);
    return $result;
}

function control_input($data)
{
    //$data=strip_tags($data);
    $data = htmlspecialchars($data);
    //$data=htmlentities($data);
    $data = stripslashes($data);
    return $data;
}

function createCategory(string $categoryName)
{
    include "ayar.php";
    $query = "INSERT INTO categories(name) VALUES (?)";
    $result = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($result, 's', $categoryName);
    mysqli_stmt_execute($result);
    mysqli_stmt_close($result);
    mysqli_close($connection);
    return $result;
}

function getCategoryById(int $id)
{
    include "ayar.php";
    $query = "SELECT * FROM categories WHERE id='$id' ";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;
}

function editCategory(int $id, string $categoryName, int $isActive)
{
    include "ayar.php";
    $query = "UPDATE categories SET name='$categoryName',isActive='$isActive' WHERE id='$id' ";
    $result = mysqli_query($connection, $query);
    return $result;
}

function deleteCategory(int $id)
{
    include "ayar.php";
    $query = "DELETE FROM categories WHERE id='$id' ";
    $result = mysqli_query($connection, $query);
    return $result;
}

function getCategoriesByBlogId(int $id)
{
    include "ayar.php";
    $query = "SELECT c.id,c.name FROM blog_category bc inner join categories c on bc.category_id=c.id WHERE bc.blog_id=$id";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;

}

function getBlogsByCategoryId(int $id)
{
    include "ayar.php";
    $query = "SELECT * FROM blog_category bc inner join blogs b on bc.blog_id=b.id WHERE bc.category_id=$id";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;

}

function getBlogsByKeyword(string $keyword)
{
    include "ayar.php";
    $query = "SELECT * FROM blogs WHERE title LIKE '%$keyword%' OR description LIKE '%$keyword%'";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;

}

function clearBlogCategories(int $id) 
{
    include "ayar.php";
    $query = "DELETE FROM blog_category WHERE blog_id=$id";
    $result = mysqli_query($connection, $query);
    return $result;
    
}

function addBlogToCategories(int $id,array $categories) 
{
    include "ayar.php";
    $query = "";
    foreach($categories as $catid){
        $query.="INSERT INTO blog_category(blog_id,category_id) VALUES ($id,$catid);";
    }
    $result = mysqli_multi_query($connection, $query);
    return $result;

}

function kisaAciklama($aciklama, $limit)
{
    if (strlen($aciklama) > $limit) {
        echo substr($aciklama, 0, $limit) . "...";
    } else {
        echo $aciklama;
    };
}


/*function getData()
{
    $myFile = fopen("db.json", "r");
    $size = filesize("db.json");
    $result = json_decode(fread($myFile, $size), true);
    fclose($myFile);
    return $result;
}

function getUser(string $username)
{
    $users = getData()["users"];

    foreach ($users as $user) {
        if ($user["username"] == $username) {
            return $user;
        }
    }
    return null;
}

function CreateUser(string $name, string $username, string $email, string $password)
{
    $db = getData();
    array_push($db["users"], [
        "id" => count($db["users"]) + 1,
        "username" => $username,
        "password" => $password,
        "name" => $name,
        "email" => $email
    ]);
    $myFile = fopen("db.json", "w");
    fwrite($myFile, json_encode($db, JSON_PRETTY_PRINT));
    fclose($myFile);
}

function addData(string $baslik, string $aciklama, string $resim, string $url, int $yorum = 0, int $begeni = 0, bool $vizyon = false)
{
    $db = getData();
    array_push($db["movies"], [
        "id" => count($db["movies"]) + 1,
        "title" => $baslik,
        "description" => $baslik,
        "url" => $url,
        "image-url" => $resim,
        "likes" => $begeni,
        "comments" => $yorum,
        "vizyon" => $vizyon
    ]);
    $myFile = fopen("db.json", "w");
    fwrite($myFile, json_encode($db, JSON_PRETTY_PRINT));
    fclose($myFile);
}

function getBlogById(int $id)
{
    $movies = getData()["movies"];

    foreach ($movies as $movie) {
        if ($movie["id"] == $id) {
            return $movie;
        }
    }
    return null;
}

function editBlog(int $id, string $filmBaslik, string $filmAciklama, string $filmResim, string $filmUrl, bool $filmVizyon)
{
    $db = getData();

    foreach ($db["movies"] as &$movie) {
        if ($movie["id"] == $id) {
            $movie["title"] = $filmBaslik;
            $movie["description"] = $filmAciklama;
            $movie["image-url"] = $filmResim;
            $movie["url"] = $filmUrl;
            $movie["vizyon"] = $filmVizyon;

            $myFile = fopen("db.json", "w");
            fwrite($myFile, json_encode($db, JSON_PRETTY_PRINT));
            fclose($myFile);

            break;
        }
    }
}

function deleteBlog(int $id)
{
    $db = getdata();

    foreach ($db["movies"] as $key => $movie) {
        if ($movie["id"] == $id) {
            array_splice($db["movies"],$key,1);
        }
    }

    $myFile = fopen("db.json", "w");
    fwrite($myFile, json_encode($db, JSON_PRETTY_PRINT));
    fclose($myFile);
}

function filmEkle(string $baslik, string $aciklama, string $resim, string $url, int $yorum = 0, int $begeni = 0, bool $vizyon = false)
{
    $myFile = fopen("veriler.txt", "a");
    $icerik = $baslik . "|" . $aciklama . "|" . $resim . "|" . $url . "|" . $yorum . "|" . $begeni . "|" . (int)$vizyon;
    fwrite($myFile, $icerik . "\n");
    fclose($myFile);
}

function filmleriGetir()
{
    $myFile = fopen("veriler.txt", "r");
    $liste = [];
    while (($satir = fgets($myFile)) !== false) {
        $dilimler = explode("|", $satir);

        array_push($liste, [
            "filmBaslik" => $dilimler[0],
            "filmAciklama" => $dilimler[1],
            "filmResim" => $dilimler[2],
            "filmUrl" => $dilimler[3],
            "filmYorum" => $dilimler[4],
            "filmBegeni" => $dilimler[5],
            "filmVizyon" => $dilimler[6]
        ]);
    }
    fclose($myFile);
    return $liste;
}*/

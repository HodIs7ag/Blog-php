
<?php
include "templates/header.php";


if (!isLoggedIn()){
    header("Location: ./login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM posts WHERE `PostID` = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ./index.php");
    } else {
        echo "Error deleting post";
    }
} else {
    echo "Post not found";
}

?>
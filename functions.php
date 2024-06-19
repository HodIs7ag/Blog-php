<?php
//check if user is logged in
function isLoggedIn(){
    if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == true) {
        return true;
    }
    return false;
    
}

//get post tags
function getPostTags($postID, $conn){
    $sql = "SELECT t.`TagName` FROM tags t
    JOIN post_tags pt ON t.TagID = pt.TagID
    WHERE pt.PostID = $postID;";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $tags = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $tagslist = ' ';
            foreach ($tags as $tag) {
                $tagslist .= $tag['TagName'] . ', ';
            }
            return $tagslist;
        }
    }
}
$alert = '';


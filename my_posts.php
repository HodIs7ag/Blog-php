<?php
include 'templates/header.php';
//get posts related to this user only
if (isLoggedIn()) {
    $sql = "SELECT p.`PostID`, p.`Title`, p.`Content`, c.`CategoryName` AS Category, p.`CreatedAt` FROM `posts` p
    JOIN categories c ON p.CategoryID = c.CategoryID 
    WHERE p.UserID = {$_SESSION['UserID']};";
    $result = mysqli_query($conn, $sql); 
    if ($result) {
    
        //if posts exist
        if (mysqli_num_rows($result) > 0) {

            $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
        } else {
            echo 'No posts found here';
        }
    }
} else {
    header('Location: ./index.php');
}

?>

<!-- display posts show edit and delete buttons-->
<div class="container posts">
    <section class="posts">
        <h3 class="header text-success">My Posts</h3>

        <?php
        if (isset($posts) && !empty($posts))  {
            foreach ($posts as $post) {
               
                echo '<div class="post">';
                echo    '<div class="post-header">';
                echo        '<p" class="post-category">' . $post['Category'] . '</p>';
                echo        '<h1 class="post-title"><strong>' . $post['Title'] . '</strong></h1>';
                echo        '<p class="post-meta">' . date('F j, Y', strtotime($post['CreatedAt'])) . '</p>';
                echo        '<p Tags: ' .getPostTags($post['PostID'], $conn) .'</p>';
                echo    '</div>';
                echo '<div class="post-content">';
                echo '<p>' . $post['Content'] . '</p>';
                echo '</div>';
                echo '<div class="post-actions">';
                echo '<a href="post.php?id=' . $post['PostID'] . '" class="btn btn-primary">Show</a>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>

    </section>
</div>

<?php
  include 'templates/footer.php';
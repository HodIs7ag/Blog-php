

<?php

  include 'templates/header.php';

    // get post id from query string
    if (isset($_GET['id'])) {
        $PostID = $_GET['id'];
        $sql = "SELECT  p.`Title`, p.`Content`, c.`CategoryName` AS Category,         
        p.`CreatedAt`, p.`UpdatedAt`, p.`UserID`,
        u.`UserID`, u.`FirstName` AS UserFirstName, u.`LastName` AS UserLastName
        FROM `posts` p
        JOIN users u ON p.UserID = u.UserID
        JOIN categories c ON p.CategoryID = c.CategoryID
        WHERE p.PostID = $PostID;";
        $result = mysqli_query($conn, $sql);    

        if ($result) {
            //if post exists
            if (mysqli_num_rows($result) > 0) {
                $post = mysqli_fetch_assoc($result);
                $title = $post['Title'];
                $content = $post['Content'];
                $created_at = $post['CreatedAt'];
                
                $updated_at = $post['UpdatedAt'];
                $user_name = $post['UserFirstName'] . ' ' . $post['UserLastName'];
                $user_id = $post['UserID'];
                $category = $post['Category'];

            } else {
                echo 'Post not found';
            }
        }
    } else {
        echo 'Post not found';
    }

?>


<!-- display post -->
<div class="container post">
    <article class="post">

        <div class="post-header">
            <p" class="post-category"><?php echo $category; ?></p>
            <h1 class="post-title"><strong><?php echo $title; ?></strong></h1>
            <p class="post-meta">
                <?php echo date('F j, Y', strtotime($created_at)) .'  by ' . $user_name; ?>
            </p>

            <p> <?php echo 'Tags: ' .getPostTags($PostID, $conn);?></p>
        </div>

        <div class="post-content mt-5">
            <p><?php echo $content; ?></p>
        </div>

        <div class="post-footer">
            <p class="post-updated">Last updated: <?php echo date('F j, Y', strtotime($updated_at)); ?></p>
        </div>

        <?php
        if (isLoggedIn() && $_SESSION['UserID'] == $user_id) {
            echo '<a href="edit_post.php?id=' . $PostID . '" class="btn btn-primary">Edit</a>';
            echo '<a href="delete_post.php?id=' . $PostID . '" class="btn btn-danger">Delete</a>';
        }
        ?>

        <!-- comments -->
        <div class="post-comments">
            <h5>Comments</h5>
            <ul class="comment-list">
                <?php
                    include "./comments.php"
                ?>
            </ul>
        </div>
        
        <!-- add new comment -->
        <?php
        if (isLoggedIn()) {
            
        ?>
        <div class="add-comment">
            <form action="./add_comment.php" method="POST">
                <div class="form-group">
                    <textarea name="comment" class="form-control" rows="3" placeholder="Comment"></textarea>
                </div>
                <input type="hidden" name="PostID" value="<?php echo $PostID; ?>">
                <button type="submit" class="btn btn-sm btn-primary">send</button>

            </form>
        </div>
        <?php
        }?>
    </article>

</div>

<?php
  include 'templates/footer.php';
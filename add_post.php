

<?php

include 'templates/header.php';

//check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

//check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category']) && isset($_POST['tags'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $tags = $_POST['tags'];

        echo 'title: ' . $title . '<br>';
        echo 'content: ' . $content . '<br>';
        echo 'category: ' . $category . '<br>';
        echo 'tags: ' . $tags . '<br>';
        echo 'user id: ' . $_SESSION['UserID'] . '<br>';
        //validate form data
        if (empty($title) || empty($content) || empty($category) || empty($tags)) {
            echo 'All fields are required';
        } else {

            try {
                //insert new post into database
                echo 'title: ' . $title . '<br>';
                $sql = "INSERT INTO posts (`Title`, `Content`, `CategoryID`,`UserID`)"
                ." VALUES ('$title', '$content', $category, {$_SESSION['UserID']});";
                $result = mysqli_query($conn, $sql);
                $postID = mysqli_insert_id($conn);
                echo 'post id: ' . $postID . '<br>';

                // insert tags into database
                $tags = explode(',', $tags);
                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    $sql = "INSERT INTO tags (`TagName`) VALUES ('$tag')";
                    mysqli_query($conn, $sql);

                    // insert into post_tags table
                    $tagID = mysqli_insert_id($conn);
                    $sql = "INSERT INTO post_tags (`PostID`, `TagID`) VALUES ($postID, $tagID)";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        throw new Exception('Error adding tags');
                        exit;
                    } else {
                        header('Location: post.php?id=' . $postID);
                    }
                }
                
            } catch (Exception $e) {
                echo 'Error: ' . $e;
            }
            

            
        }
    }
}
?>

<!-- add post form -->

<div class="container">
    <section class="add-post">
        <h3 class="header text-success">Add New Post</h3>

        <form class="add-post-form" action="./add_post.php" method="POST">
    
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" id="content" rows="3" placeholder="Content"></textarea>
            </div>

            
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" class="form-control" id="category">
                    <?php
                    //get categories from database
                    $sql = "SELECT * FROM categories";
                    $categories = mysqli_query($conn, $sql);
                    if ($categories) {
                        if (mysqli_num_rows($categories) > 0) {
                            $categories = mysqli_fetch_all($categories, MYSQLI_ASSOC);
                            foreach ($categories as $category) {
                                echo '<option value="' . $category['CategoryID'] . '">' . $category['CategoryName'] . '</option>';
                            }
                        }
                    }
                    
                    ?>
                </select>
            </div>

            
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" name="tags" class="form-control" id="tags" placeholder="Tags">
            </div>
            
            <button type="submit" class="btn btn-primary">Publish</button>
            <a href="profile.php" class="btn btn-danger">Cancel</a>
                

</div>


<?php
include 'templates/footer.php';

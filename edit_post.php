<?php
include 'templates/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $post_id = $_GET['id'];
        $sql = "SELECT p.`PostID`, p.`Title`, p.`Content`, c.`CategoryName` AS Category, p.`CreatedAt` FROM `posts` p
        JOIN categories c ON p.CategoryID = c.CategoryID
        WHERE p.PostID = $post_id;";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $post = mysqli_fetch_assoc($result);
            } else {
                echo 'Post not found';
                exit();
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['category'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $post_id = $_POST['post_id'];

        $sql = "UPDATE `posts` SET `Title` = '$title', `Content` = '$content', `CategoryID` = $category WHERE `PostID` = $post_id;";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('Location: post.php?id=' . $post_id);
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<!-- prefilled post edit form -->
<div class="container post-edit">
    <section class="post-edit">
        <h3 class="header text-success">Edit Post</h3>

        <form class="post-edit-form" action="./edit_post.php" method="POST">
            <input type="hidden" name="post_id" value="<?php echo $post['PostID']; ?>">
            <div class="form-row">
                <!-- title -->
                <div class="form-group col-md-6">
                    <input type="text" name="title" class="form-control py-4 border-left" id="title" aria-describedby="idHelp" placeholder="Title" value="<?php echo $post['Title']; ?>">
                </div>
                <!-- category -->
                <div class="form-group
                col-md-6">
                    <select name="category" class="form-control py-4 border-left" id="category">
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
            </div>
            <!-- content -->
            <div class="form-group">
                <textarea name="content" class="form-control py-4 border-left" id="content" rows="10" placeholder="Content"><?php echo $post['Content']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </section>
</div>  
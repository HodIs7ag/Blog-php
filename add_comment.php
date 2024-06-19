<?php
// Path: add_comment.php
// handles the form submission to add a comment to a post

include 'templates/header.php';

// check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comment']) && isset($_POST['PostID'])) {
        $comment = $_POST['comment'];
        $PostID = $_POST['PostID'];

        // insert new comment into database
        $sql = "INSERT INTO comments (`Content`, `PostID`, `UserID`) VALUES ('$comment', $PostID, {$_SESSION['UserID']});";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("Location: ./post.php?id=$PostID");
        } else {
            echo 'Error adding comment: '. mysqli_error($conn);
        }
        
    } else {
        echo 'Error adding comment: '. mysqli_error($conn);
    }
}
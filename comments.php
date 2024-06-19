<?php
    $sql = "SELECT c.`Content`, c.`CreatedAt`, u.`UserID`, u.`FirstName`, u.`LastName` FROM `comments` c
    JOIN users u ON c.UserID = u.UserID
    WHERE c.PostID = $PostID;";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($comment = mysqli_fetch_assoc($result)) {
                $comment_content = $comment['Content'];
                $comment_user = $comment['FirstName'] . ' ' . $comment['LastName'];
                $comment_created_at = $comment['CreatedAt'];
                ?>
                <li class="comment p-0">
                    <p class="comment-content">
                        <?php echo $comment_user . ': '.$comment_content .'  '
                        .'<span class="date">' .date('g:i a, F j ', strtotime($comment_created_at)); '</span>'?>
                    </p>
                    
                </li>

                <?php
            }
            
        } else {
            echo 'No comments yet';
        }
    }
?>
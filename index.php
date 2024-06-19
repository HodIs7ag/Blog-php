<?php
// Path: index.php

  include 'templates/header.php';
  // get all posts from database and show sorted by latest first
  $sql = "SELECT p.`PostID`, p.`Title`, p.`Content`, c.`CategoryName` AS Category, p.`CreatedAt`, p.`UpdatedAt`, p.`UserID`, u.`FirstName` AS UserFirstName, u.`LastName` AS UserLastName FROM `posts` p
  JOIN users u ON p.UserID = u.UserID
  JOIN categories c ON p.CategoryID = c.CategoryID
  ORDER BY p.CreatedAt DESC;";

  $result = mysqli_query($conn, $sql);
  if ($result) {
      //if posts exist
      if (mysqli_num_rows($result) > 0) {
          $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
      } else {
          echo 'No posts found';
      }
  } else {
      echo 'Error: ' . mysqli_error($conn);
  }
?>
<!-- display posts' titles users and category without contents  -->
<div class="container">
    <section class="posts">
        <h3 class="header text-success">All Posts</h3>

        <?php
        if (isset($posts)) {
            foreach ($posts as $post) {
                echo '<div class="post">';
                echo '<div class="post-header">';
                echo '<h1 class="post-title"><strong>' . $post['Title'] . '</strong></h1>';
                echo '<p class="post-meta">' . date('F j, Y', strtotime($post['CreatedAt'])) . ' by ' . $post['UserFirstName'] . ' ' . $post['UserLastName']
                .'     | ' . $post['Category'] .'</p>';
                echo '</div>';
                echo '<div class="post-actions">';
                echo '<a href="post.php?id=' . $post['PostID'] . '" class="btn btn-sm btn-primary">Read More</a>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>

    </section>
</div>



<?php
  include 'templates/footer.php';
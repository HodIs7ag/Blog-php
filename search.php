
 <?php
    include 'config.php';
    include 'templates/header.php';
?>

 <div class="container search">
    <section class="search-results">
        <h3 class="header text-success">Search Results</h3>



    
<?php
    // get search query from query string using GET method and ?s=keyword
    if (isset($_GET['s'])) {
        $search_query = $_GET['s'];
        $sql = "SELECT p.`PostID`, p.`Title`, p.`Content`, c.`CategoryName` AS Category, p.`CreatedAt`, p.`UpdatedAt`, p.`UserID`, u.`FirstName` AS UserFirstName, u.`LastName` AS UserLastName FROM `posts` p
        JOIN users u ON p.UserID = u.UserID
        JOIN categories c ON p.CategoryID = c.CategoryID
        WHERE p.Title LIKE '%$search_query%';";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            //if posts exist
            if (mysqli_num_rows($result) > 0) {
                $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
                
            
            if (isset($posts)) {
                foreach ($posts as $post) {
                    echo '<ul class="list-group">';
                    echo '<li class="list-group-item">';
                    echo '<a href="post.php?id=' . $post['PostID'] . '">';
                    echo $post['Title'];
                    echo '</a>';
                    echo '</li>';
                    echo '</ul>';
                }
            }
            
        
                
            } else {
                echo 'No posts found here';
            }
        }
    } else {
        echo 'No posts found';
    }

?>


        
    </section>


 </div>
 <?php
  include 'templates/footer.php';
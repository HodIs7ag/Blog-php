<?php
  require_once('./config.php');
  require_once('./functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>News</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;1,400&display=swap" rel="stylesheet">

  <style>
    .container{
      margin: 20px auto;
    }
    footer{
      /* place it at the bottom */
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;

    }

    .login {
      margin: 10% auto;
      width: 50%;
    }
  </style>

</head>
<body class="bg-light text-dark ">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand ml-3 ml-lg-5" href="#"><span>B</span>log</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto ml-3">
        <li class="nav-item active">
          <a class="nav-link" href="./index.php">All Posts <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./my_posts.php">My Posts</a>
        </li>
      
      </ul>
      <!-- add search bar  button on the left-->
      <form class="form-inline my-2 my-lg-0" action='./search.php' method="GET">

          <input class="form-control mr-sm-2" type="search" placeholder="Search by Post title" aria-label="Search" name="s">
          
        </form>
        <div class="my-2 my-lg-0">

        

          <?php if (!isLoggedIn()){
            echo '<a href="./login.php" class="btn btn-outline-success my-2 my-sm-0">Login</a>';
            
          } else {
            echo '<a href="./add_post.php" class="btn btn-outline-success my-2 my-sm-0">Add Post</a>';
            echo '<a href="./logout.php" class="btn btn-outline-danger my-2 my-sm-0">Logout</a>';
          }
          ?>
        </div>
    </div>
  </nav>

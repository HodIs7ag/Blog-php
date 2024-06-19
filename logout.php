<?php

//logic for logout
include 'config.php';
include 'functions.php';

// check if user is already logged out
if (!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn'] == false) {
    header('Location: login.php');
}

// destroy session
session_destroy();
header('Location: login.php');

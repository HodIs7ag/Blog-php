<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'blog';

session_start();

try {
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
    echo 'Connected successfully';
    mysqli_set_charset($conn, 'utf8');

    
}
catch (Exception $error) {
    die ('Connection failed:'  . $error->getMessage());
    exit;
}


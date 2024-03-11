<?php
$host = "localhost";
$db_name = "todoApp";
$username = "root";
$password = "root";

try{
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
} catch(PDOexception $exception){
    echo "Error: " . $exception->getMessage();
    var_dump($exception->getMessage());
}

// 1. Set pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page;
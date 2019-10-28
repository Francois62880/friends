<?php
session_start();
require 'db.php';
if(!empty($_POST['username'])){

$query = $pdo->prepare("SELECT username FROM users WHERE username = :username AND password = :password");

$query->execute([
    "username"=> $_POST['username'],
    "password"=> $_POST['password']
]);

$data = $query->fetch();
if($data)
{
    $_SESSION['user'] = $_POST['username'];
    header('location:user.php');
}else{
    header('location:index.php');
}
}else{
    header('location:index.php');
}
<?php
require 'db.php';
session_start();

if($_GET['action'] == "delete" )
{
    $pdo->query("DELETE FROM friends WHERE id =" .$_GET['id']);
    header("location: user.php");
}

if($_GET['action']== "add")
{
    $query = $pdo->prepare("INSERT INTO friends(username_1, username_2, is_pending) VALUES (:username_1, :username_2, :is_pending)");
    $query->execute([
        "username_1" => $_SESSION['user'], 
        "username_2" =>  $_GET['username'], 
        "is_pending"=>  1
    ]);
    header("location: user.php");
}
if($_GET['action']== "accept")
{
    $pdo->query("UPDATE friends set is_pending = 0 WHERE id =" .$_GET['id']);
    header("location: user.php");
}
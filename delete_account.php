<?php

session_start();
include("connection.php");
$connection = require_once 'connection_notes.php';


if(isset($_SESSION['user_id']))
{

    $sql = "SELECT * FROM users WHERE user_id = '$_SESSION[user_id]'";
    $result = mysqli_query($con,$sql);
    $user_data = mysqli_fetch_assoc($result);

    $user_id = $user_data['user_id'];
    $username = $user_data['user_name'];

    $sql_users = "DELETE FROM users WHERE user_id = '$user_id'";
    $sql_notes = "DELETE FROM notes WHERE username = '$username'";

    mysqli_query($con, $sql_users);

    $connection->delete_acc($username);

    unset($_SESSION['user_id']);

}


header("Location: index.html");
die;
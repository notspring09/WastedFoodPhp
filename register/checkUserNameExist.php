<?php
require "../connection.php";
require "../model/buyer.php";

//get 3rd party id


$username = $_GET["username"];

$username = mysqli_real_escape_string($connect,$username);

$query = "SELECT `username` from `account` WHERE `username` = '$username'";
$result = $connect->query($query);

if($result->num_rows<=0){
    echo 'notExist';
} else{
    echo 'exist';
}


?>

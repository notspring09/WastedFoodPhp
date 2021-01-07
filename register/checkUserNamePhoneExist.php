<?php
require "../connection.php";
require "../model/buyer.php";

//get 3rd party id


$phone = $_GET["phone"];
$username = $_GET["username"];

$phone = mysqli_real_escape_string($connect,$phone);

$query = "SELECT phone from account WHERE phone =  '$phone' and username = '$username'";
$result = $connect->query($query);

if($result->num_rows<=0){
    echo 'notExist';
} else{
    echo 'exist';
}
?>

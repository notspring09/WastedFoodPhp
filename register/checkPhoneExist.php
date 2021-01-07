<?php
require "../connection.php";
require "../model/buyer.php";

//get 3rd party id

$phone = $_GET["phone"];

$phone = mysqli_real_escape_string($connect,$phone);

$query = "SELECT `phone` from `account` WHERE `phone` = '$phone' and role_id = '2'";
$result = $connect->query($query);

if($result->num_rows<=0){
    echo 'notExist';
} else{
    echo 'exist';
}


?>

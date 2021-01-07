<?php
require "../connection.php";
require "../model/buyer.php";

//get 3rd party id


$emailUser = $_GET["emailUser"];

$emailUser = mysqli_real_escape_string($connect,$emailUser);

$query = "SELECT `email` from `account` WHERE `email` = '$emailUser' and role_id = '2'";
$result = $connect->query($query);

if($result->num_rows<=0){
    echo 'notExist';
} else{
    echo 'exist';
}
?>

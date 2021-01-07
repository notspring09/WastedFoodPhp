<?php
require "../connection.php";

$id = $_REQUEST['id'];
$role = 3;
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];

$query = "INSERT INTO `account` (`id`,`role_id`,`username`,`password`,`phone`,`email`) VALUES ($id,$role,$username,$password,$phone,$email)";

if($connect->query($query)===TRUE){
    $date_of_birth - $_REQUEST['dob'];
    $image = $_REQUEST['image'];
    $gender = $_REQUEST['gender'];
    $query = "INSERT INTO `buyer` (`account_id`,`date_of_birth`,`image`,`gender`,`modified_date`) VALUES ($id,$date_of_birth,$image,$gender)";
    if($connect->query($query)=== TRUE){
        echo "success";
    }
    else echo $connect->error;

}else {
    echo $connect->error;
}

$connect->close();

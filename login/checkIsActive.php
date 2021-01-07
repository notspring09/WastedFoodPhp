<?php
require "../connection.php";
require "../model/buyer.php";

//get 3rd party id

$account_id = $_REQUEST["account_id"];

$account_id = mysqli_real_escape_string($connect,$account_id);

$query = "SELECT `is_active` from `account` WHERE `id` = '$account_id'";
$result = $connect->query($query);

while($row = mysqli_fetch_assoc($result)){
    $active = $row['is_active'];
}
//get role_id and id

if(!$active){
    //return error
    echo "account is locked";
    exit();
}


?>

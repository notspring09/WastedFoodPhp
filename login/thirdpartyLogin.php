<?php
require "../connection.php";
require "../model/buyer.php";

//get 3rd party id
$thirdPartyId = $_REQUEST["thirdPartyId"];

$thirdPartyId = mysqli_real_escape_string($connect,$thirdPartyId);

$query = "SELECT `id`,`phone` FROM `account` WHERE `third_party_id` = '$thirdPartyId'";


//3rd party id not exist => move to register
if($result->num_rows<=0){
    //return error
    echo "NOT_EXIST_ID";
    exit();
}
//check exist an account
//execute query
$result = $connect->query($query);

$id = 0;
$phone = "";

//get id and phone
while($row = mysqli_fetch_row($result)){
    $id = $row[0];
    $phone = $row[1];
}

//return if phone null. check string like this to move to register phone
if($phone == null){
    echo "PHONE_IS_NULL";
    exit();
}

$query = "SELECT `account_id`,`name`,`date_of_birth`,`image`,`gender` FROM `buyer` WHERE `account_id` = $id";
$result = $connect->query($query);



$listBuyer = array();

while($row = mysqli_fetch_assoc($result)){
    array_push($listBuyer, new Buyer($row['account_id'],null,null,null,null,null,null,null,null,$row['name'],$row['date_of_birth'],$row['image'],$row['gender']));
}


//return json object for login
echo json_encode($listBuyer);

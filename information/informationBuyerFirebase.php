<?php
require "../connection.php";
require "../model/buyer.php";

//get username and password from url parameters
$account_id = $_REQUEST['account_id'];


$account_id = mysqli_real_escape_string($connect, $account_id);

//sql string get info

$query = "SELECT `id`, `role_id`, `username`, `password`, `phone`, 
    `third_party_id`, `email`, `created_date`, `is_active`, 
    `date_of_birth`, `name`, `image`, `gender`,firebase_UID
FROM `account` 
JOIN `buyer` 
ON `account`.`id` = `buyer`.`account_id` 

WHERE `account`.`id` = '$account_id';";

// $result = $connect->query($query);
$result = mysqli_query($connect,$query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($connect), E_USER_ERROR);


$listBuyer = array();

while($row = mysqli_fetch_assoc($result)){
    array_push($listBuyer, new Buyer($row['id'], $row['role_id'], $row['username'], $row['password'], $row['phone'],$row['third_party_id'], $row['email'], $row['created_date'], $row['is_active'],$row['firebase_UID'], $row['name'],$row['date_of_birth'],$row['image'],$row['gender']));
}
//return json object if not error
echo json_encode($listBuyer);

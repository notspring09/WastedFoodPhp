<?php
require "../connection.php";
require "../model/buyer.php";

//get username and password from url parameters
$phone = $_REQUEST['phone'];
$password = $_REQUEST['password'];


//remove special string from parameters
$phone = mysqli_real_escape_string($connect, $phone);
$password = mysqli_real_escape_string($connect, $password);

//sql string get info
// $query = "SELECT `id`,`role_id`,`is_active` FROM `account` WHERE `phone` = '$phone' AND `password` = '$password'";

$query = <<<EOF
        SELECT `id`, `role_id`, `username`, `password`, `phone`, 
            `third_party_id`, `email`, `created_date`, `is_active`, 
            `date_of_birth`, `name`, `image`, `gender`, `firebase_UID`
        FROM `account` 
        JOIN `buyer` 
        ON `account`.`id` = `buyer`.`account_id` 
        WHERE `phone` = '$phone' 
            AND `password` = '$password'
            AND `role_id` = 3
            AND `is_active` = 1;
EOF;

//check exist an account
//execute query
$result = $connect->query($query);

if($result->num_rows<=0){
    //return error
    echo "not exist account";
    exit();
}

//get role id
$role_id = 0;
$active = true;


$listBuyer = array();

while($row = mysqli_fetch_assoc($result)){
    $role_id = $row['role_id'];
    $active = $row['is_active'];
    array_push($listBuyer, new Buyer($row['id'], $row['role_id'], $row['username'], $row['password'], $row['phone'],$row['third_party_id'], $row['email'], $row['created_date'], $row['is_active'],$row['firebase_UID'], $row['name'],$row['date_of_birth'],$row['image'],$row['gender'] ));
}
//get role_id and id

if($role_id!=3){
    //return error
    echo "not match role";
    exit();
}

if(!$active){
    //return error
    echo "account is locked";
    exit();
}

// $query = "SELECT `account_id`,`date_of_birth`,`name`,`image`,`gender` FROM `buyer` WHERE `account_id` = $id";
// $result = $connect->query($query);
// $result = mysqli_query($connect,$query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($connect), E_USER_ERROR);


//return json object if not error
echo json_encode($listBuyer);

?>

<?php
require "../connection.php";
require "../model/seller.php";
//get username and password from url parameters
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
//$username = "test";
//$password = "12707736894140473154801792860916528374";


//remove special string from parameters
$username = mysqli_real_escape_string($connect, $username);
$password = mysqli_real_escape_string($connect, $password);

//sql string get info
$query = <<<EOF
        SELECT `id`, `role_id`, `username`, `password`, `phone`, 
            `third_party_id`, `email`, `created_date`, `is_active`, 
            `name`,`image`,`address`,`latitude`,`longitude`,`description`,`firebase_UID`
        FROM `account` 
        JOIN `seller` 
        ON `account`.`id` = `seller`.`account_id` 
        WHERE `username` = '$username' 
            AND `password` = '$password'
EOF;
//check exist an account
//execute query
$result = $connect->query($query);

if ($result->num_rows <= 0) {
    //return error
    echo "not exist account";
    $connect->close();
    exit();
}

$role_id = 0;
$active = 0;

$listSeller = array();

while ($row = mysqli_fetch_assoc($result)) {
    $role_id = $row['role_id'];
    $active = $row['is_active'];
    array_push($listSeller, new Seller($row['id'], $row['role_id'], $row['username'], $row['password'], $row['phone'], $row['third_party_id'], $row['email'], $row['created_date'], $row['is_active'], null, $row['name'], $row['image'], $row['address'], $row['latitude'], $row['longitude'], $row['description'], null, null));
}

if ($role_id != 2) {
    //return error
    echo "not match role";
    $connect->close();
    exit();
}

if ($active == 0) {
    //return error
    echo "account is locked";
    exit();
}

if ($active == 2) {
    //return error
    echo "account is not active";
    exit();
}

// $query = "SELECT `account_id`,`name`,`image`,`address`,`latitude`,`longitude`,`description` FROM `seller` WHERE `account_id` = $id";
// $result = $connect->query($query);


// class Seller{
//     function Seller($account_id,$name,$image,$address,$latitude,$longitude,$description){
//         $this->account_id = $account_id;
//         $this->name = $name;
//         $this->image = $image;
//         $this->address = $address;
//         $this->latitude = $latitude;
//         $this->longitude = $longitude;
//         $this->description = $description;
//     }
// }

//return json object if not error
echo json_encode($listSeller);
$connect->close();

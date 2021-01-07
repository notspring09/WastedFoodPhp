<?php
require "../connection.php";
require "../model/product.php";
require "../model/seller.php";

$seller_id = $_REQUEST['seller_id'];
$lat = $_REQUEST['lat'];
$lng = $_REQUEST['lng'];

//escape special characters in variable
$seller_id = mysqli_real_escape_string($connect, $seller_id);
$lat = mysqli_real_escape_string($connect, $lat);
$lng = mysqli_real_escape_string($connect, $lng);

//get seller info
$query = <<<EOF
    SELECT `account_id`,`firebase_UID`, `name`, `image`,`address`,`latitude`,`longitude`,`description`, `rating`,
    ( ( ( acos( sin(( $lat * pi() / 180)) * sin(( `latitude` * pi() / 180)) + cos(( $lat* pi() /180 )) * cos(( `latitude` * pi() / 180)) * cos((( $lng - `longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance 
    FROM `seller` 
    JOIN `account` ON `account`.`id` = `seller`.`account_id` 
    WHERE `account_id` = $seller_id;
EOF;

$result = $connect->query($query);

$seller = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $seller = new Seller($row['account_id'], null, null, null, null, null, null, null, null,$row['firebase_UID'], $row['name'], $row['image'], $row['address'], $row['latitude'], $row['longitude'], $row['description'], $row['distance'],$row['rating']);
}


//get list product
$query = <<<EOF
SELECT `product`.`id`,`seller_id`,`name`,`image`,`start_time`, `end_time`, `original_price`,`sell_price`,
 `original_quantity`, `remain_quantity`,`description`,`sell_date`,`status`,`shippable` FROM `product` 
 WHERE `seller_id` = $seller_id
 AND DATE(`sell_date`) = CURRENT_DATE()
 ORDER BY `remain_quantity` DESC
EOF;

$result = $connect->query($query);


$listProduction = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($listProduction, new Product($row['id'], $row['seller_id'], $row['name'], $row['image'], $row['start_time'], $row['end_time'], $row['original_price'], $row['sell_price'], $row['original_quantity'], $row['remain_quantity'], $row['description'], $row['sell_date'], $row['status'], $row['shippable'],$seller));
}

echo json_encode($listProduction);

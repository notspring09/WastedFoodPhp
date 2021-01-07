<?php
require "../connection.php";
require "../model/product.php";
require "../model/seller.php";
//sample place
// $lat = 21.0110168;
// $lng = 105.5182143;
$page = 1;

$lat = $_REQUEST['lat'];
$lng = $_REQUEST['lng'];
$distance = $_REQUEST['distance'];

$start_time = $_REQUEST['start_time'];
$end_time = $_REQUEST['end_time'];
$discount = $_REQUEST['discount'];
$search_text = $_REQUEST['search_text'];
$buyer_id = $_REQUEST['buyer_id'];
//sample distance
// $distance = 150; //$_REQUEST['distance']


//escape special characters in variable
$lat = mysqli_real_escape_string($connect, $lat);
$lng = mysqli_real_escape_string($connect, $lng);
$distance = mysqli_real_escape_string($connect, $distance);
$start_time = mysqli_real_escape_string($connect, $start_time);
$end_time = mysqli_real_escape_string($connect, $end_time);
$discount = mysqli_real_escape_string($connect, $discount);
$search_text = mysqli_real_escape_string($connect, $search_text);
$buyer_id = mysqli_real_escape_string($connect, $buyer_id);

if (!empty($_REQUEST['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if (false === $page) {
        $page = 1;
    }
}

$items_per_page = 5;
$offset = ($page - 1) * $items_per_page;

$query = "SELECT `product`.`id` AS `product_id`,`seller_id`,
        `product`.`name` AS `product_name`,`product`.`image` AS `product_image`,
        `start_time`, `end_time`, `original_price`,`sell_price`, `original_quantity`,
        `remain_quantity`,`product`.`description` AS `product_description`,`sell_date`,`status`,`shippable`,
        `account_id`, `currents`.`name` AS `seller_name`, `currents`.`image` AS `seller_image`,
        `address`,`latitude`,`longitude`,`currents`.`description` AS `seller_description`, `firebase_UID`,`rating`, distance
        FROM `product` JOIN 
            (   SELECT `account_id`, `name`, `image`,`address`,`latitude`,`longitude`,`description`, `firebase_UID`,`rating`, distance FROM 
                    (   SELECT `account_id`, `name`, `image`,`address`,`latitude`,`longitude`,`description`, `firebase_UID`, `rating`,
                            ( ( ( acos( sin(( $lat * pi() / 180)) * sin(( `latitude` * pi() / 180)) + cos(( $lat* pi() /180 )) * cos(( `latitude` * pi() / 180)) * cos((( $lng - `longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance 
                        FROM `seller` 
                        JOIN `account` ON `account`.`id` = `seller`.`account_id`) 
                    markers 
                    JOIN `list_follow` ON markers.`account_id` = `list_follow`.`seller_id` 
                    WHERE `list_follow`.`buyer_id` = $buyer_id AND `list_follow`.`is_follow` = 1";
if (!empty($distance))
    $query = $query . " AND distance <= $distance ";

$query = $query . ") currents 
        ON currents.`account_id` = `product`.`seller_id`
        WHERE DATE(`sell_date`) = CURRENT_DATE AND `remain_quantity` > 0
        AND `product`.`status` = 'SELLING'
    ";

if (!empty($start_time))
    $query = $query . " AND TIME(`start_time`) >= '$start_time'";

if (!empty($start_time))
    $query = $query . " AND TIME(`end_time`) <= '$end_time' ";

if (!empty($discount))
    $query = $query . " AND (100 - `product`.`sell_price` / `product`.`original_price` * 100) >= $discount ";

if (!empty($search_text))
    $query = $query . " AND `product`.`name` LIKE '%$search_text%' ";

$query = $query . "ORDER BY `distance` ASC, `remain_quantity` DESC";

$result = mysqli_query($connect, $query . ";");
$total_rows = $result->num_rows;
$total_pages = ceil($total_rows / $items_per_page);

if ($page <= $total_pages) {
    $query = $query . " LIMIT $offset ,$items_per_page;";
    // $result = $connect->query($query);

    $result = mysqli_query($connect, $query) or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($connect), E_USER_ERROR);

    $listProduction = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $seller = new Seller($row['account_id'], null, null, null, null, null, null, null, null, $row['firebase_UID'], $row['seller_name'], $row['seller_image'], $row['address'], $row['latitude'], $row['longitude'], $row['seller_description'], $row['distance'], $row['rating']);
        array_push($listProduction, new Product($row['product_id'], $row['seller_id'], $row['product_name'], $row['product_image'], $row['start_time'], $row['end_time'], $row['original_price'], $row['sell_price'], $row['original_quantity'], $row['remain_quantity'], $row['product_description'], $row['sell_date'], $row['status'], $row['shippable'], $seller));
    }

    echo json_encode($listProduction);
} else {
    echo "end";
}

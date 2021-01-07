<?php
require "../connection.php";
require "../model/order.php";
require "../model/seller.php";
require "../model/product.php";

//get buyer id
$buyer_id = $_REQUEST["buyer_id"];

//test customer
// $buyer_id = 3002;

$query = "SELECT `order`.`id` AS `order_id`,`buyer_id`,`product_id`,`quantity`,
        `order`.`status` AS `order_status`,`total_cost`,`buyer_rating`, `buyer_comment`, 
        `product`.`id` AS `product_id`,`seller_id`,
        `product`.`name` AS `product_name`, `product`.`image` AS `product_image`, 
        `start_time`, `end_time`,`original_price`, `sell_price`, `original_quantity` , 
        `remain_quantity` , `product`.`description` AS `product_description`, `sell_date` , `product`.`status` AS `product_status`,`shippable`,
        `account_id`,`seller`.`name` AS `seller_name`,`seller`.`image` AS `seller_image`,
        `address`,`latitude`,`longitude`,`seller`.`description` AS `seller_description`, `rating`
FROM `order` JOIN `product` ON `product`.`id` = `order`.`product_id` 
JOIN `seller` ON `seller`.`account_id` = `product`.`seller_id` 
WHERE `buyer_id` = $buyer_id
ORDER BY `order`.`id` DESC";

$result = $connect->query($query);

$listOrderProducts = array();

while ($row = mysqli_fetch_assoc($result)) {
    $seller = new Seller($row['account_id'], null, null, null, null, null, null, null,null, null, $row['seller_name'], $row['seller_image'], $row['address'], $row['latitude'], $row['longitude'], $row['seller_description'], null,$row['rating']);
    $product = new Product($row['product_id'], $row['seller_id'], $row['product_name'], $row['product_image'], $row['start_time'], $row['end_time'], $row['original_price'], $row['sell_price'], $row['original_quantity'], $row['remain_quantity'], $row['product_description'], $row['sell_date'], $row['product_status'], $row['shippable'], $seller);
    array_push($listOrderProducts, new Order($row['order_id'], $row['buyer_id'], $row['product_id'], $row['quantity'], $row['order_status'], $row['total_cost'], $row['buyer_comment'],$product));
}

echo json_encode($listOrderProducts);

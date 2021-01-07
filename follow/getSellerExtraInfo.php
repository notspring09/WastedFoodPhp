<?php
require "../connection.php";
require "../model/seller.php";

// //sample place
// $lat = 21.0110168;
// $lng = 105.5182143;


// //sample distance
// $distance = 150; //$_REQUEST['distance']


// //escape special characters in variable
// $lat = mysqli_real_escape_string($connect, $lat);
// $lng = mysqli_real_escape_string($connect, $lng);
// $distance = mysqli_real_escape_string($connect, $distance);

$id = $_REQUEST['id'];

$id = mysqli_real_escape_string($connect, $id);
$query = <<<EOF
    SELECT COUNT(*) AS `follow_total`
    FROM `seller`
    JOIN `list_follow`
    ON `seller`.`account_id` = `list_follow`.`seller_id`
    WHERE `seller_id` = $id AND `list_follow`.`is_follow` = 1
EOF;

$result = $connect->query($query);

$follow_total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $follow_total = $row['follow_total'];
}

$query = <<<EOF
    SELECT SUM( `product`.`original_quantity` - `product`.`remain_quantity`) AS `product_total`
    FROM `seller`
    JOIN `product`
    ON `seller`.`account_id` = `product`.`seller_id`
    WHERE `seller_id` = $id
EOF;

$result = $connect->query($query);
$product_total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $product_total = $row['product_total'];
}

class SellerExtraInfo
{
    public $follow_total;
    public $product_total;
    public function __construct($follow_total, $product_total)
    {
        $this->follow_total = $follow_total;
        $this->product_total = $product_total;
    }
}


echo json_encode(new SellerExtraInfo($follow_total, $product_total));

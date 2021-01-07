<?php
require "../connection.php";

$seller_id =  $_REQUEST['seller_id'];


//escape special characters in variable

$seller_id = mysqli_real_escape_string($connect, $seller_id);

$query = "SELECT `product`.`id`,`seller_id`,`name`,`image`,`start_time`, `end_time`,
 `original_price`,`sell_price`, `original_quantity`, `remain_quantity`,`description`
 ,`sell_date`,`status`,`shippable` 
FROM `product` INNER JOIN account ON product.seller_id = account.id WHERE account.id = '$seller_id'";

$result = $connect->query($query);

//Class product
class Product
{
    function Product($id, $seller_id, $name, $image, $start_time, $end_time, $original_price, $sell_price, $original_quantity, $remain_quantity, $description, $sell_date, $status, $shippable)
    {
        $this->id = $id;
        $this->seller_id = $seller_id;
        $this->name = $name;
        $this->image = $image;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->original_price = $original_price;
        $this->sell_price = $sell_price;
        $this->original_quantity = $original_quantity;
        $this->remain_quantity = $remain_quantity;
        $this->description = $description;
        $this->sell_date = $sell_date;
        $this->status = $status;
        $this->shippable = $shippable;
    }
}

$listProduction = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($listProduction, new Product($row['id'], $row['seller_id'], $row['name'], $row['image'], $row['start_time'], $row['end_time'], $row['original_price'], $row['sell_price'], $row['original_quantity'], $row['remain_quantity'], $row['description'], $row['sell_date'], $row['status'], $row['shippable']));
}

echo json_encode($listProduction);

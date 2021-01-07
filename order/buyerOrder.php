<?php 
require "../connection.php";

$buyer_id = $_POST["buyer"];
$product_id = $_POST["product"];
$quantity = $_POST["quantity"];
$status = $_POST["status"];
$total_cost = $_POST["total_cost"];


//buyer order not yet need
// $buyer_rating = $_POST["buyer_rating"];
// $buyer_comment = $_POST["buyer_comment"];

$query = "UPDATE `product` SET `remain_quantity` = `remain_quantity` - $quantity WHERE `product`.`id` = $product_id AND `remain_quantity` - $quantity > -1;";

if(!mysqli_query($connect,$query)){
    echo "NOT ENOUGH";
}

$query = "INSERT INTO `order` ( `buyer_id`, `product_id`, `quantity`, `status`, `total_cost`, `buyer_rating`, `buyer_comment`) VALUES ( '$buyer_id', '$product_id', '$quantity', '$status', '$total_cost', NULL, NULL);";

// Show bug
//$result = mysqli_query($connect,$query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($connect), E_USER_ERROR);

if(mysqli_query($connect,$query)){
    $query = "SELECT * FROM `order`;";
    $result = mysqli_query($connect,$query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($connect), E_USER_ERROR);
echo $result->num_rows;
}else{
    echo "ERROR";
    $connect->rollback();
}
$connect->close();


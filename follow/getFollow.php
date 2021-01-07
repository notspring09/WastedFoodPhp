<?php
require "../connection.php";

$buyer_id = $_REQUEST["buyer_id"];
$seller_id = $_REQUEST["seller_id"];

$query = "SELECT `is_follow` FROM `list_follow` WHERE `buyer_id` = '$buyer_id' AND `seller_id` = '$seller_id';";

$result = $connect->query($query);

if($result->num_rows <=0){
    echo "FALSE";
    exit();
}

while($row = mysqli_fetch_row($result)){
    if($row[0]){
        echo "TRUE";
    }else echo "FALSE";
}

exit();
<?php
require "../connection.php";

$id = $_POST['id'];
$rating = $_POST['rating'];
$buyer_comment = $_POST['buyer_comment'];


$sql = "UPDATE `order` SET `buyer_rating` = '$rating', `buyer_comment` = '$buyer_comment' WHERE `order`.`id` = $id;";

if (!$connect->query($sql)) {
    echo "ERROR";
    $connect->rollback();
}else echo "SUCCESS";

exit();
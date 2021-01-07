<?php
require "../connection.php";


$buyer_id = $_POST["buyer_id"];
$seller_id = $_POST["seller_id"];

$is_follow = 0;
if ($_POST["is_follow"] === "true")
    $is_follow = 1;

$query = "SELECT `is_follow` FROM `list_follow` WHERE `buyer_id` = '$buyer_id' AND `seller_id` = '$seller_id';";

$result = $connect->query($query);

if ($result->num_rows <= 0)
    $query = "INSERT INTO `list_follow` (`buyer_id`, `seller_id`, `is_follow`, `modified_date`) VALUES ('$buyer_id', '$seller_id', '$is_follow', CURRENT_TIMESTAMP);";
else
    $query = "UPDATE `list_follow` SET `is_follow` = '$is_follow' WHERE `list_follow`.`buyer_id` = '$buyer_id' AND `list_follow`.`seller_id` = '$seller_id';";


if (!$connect->query($query)) {
    echo "ERROR";
    $connect->rollback();
}
exit();

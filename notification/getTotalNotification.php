<?php
require "../connection.php";

$receiver_id = $_GET['receiver_id'];
$sql = "select count(*) as total from `notification` where `receiver_id` = $receiver_id and seen = 'false'";
$result = mysqli_query($connect, $sql);
$data = mysqli_fetch_assoc($result);
echo $data['total'];

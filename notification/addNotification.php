<?php
require "../connection.php";

$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$content = $_POST['content'];
$order_id = $_POST['order_id'];
$modified_date = $_POST['modified_date'];

$query = "INSERT INTO `notification` (`sender_id`,`receiver_id`,`content`, `order_id` , `modified_date` ) VALUES ('$sender_id' , '$receiver_id' , '$content' , '$order_id' , '$modified_date')";

//trigger bug
//$result = mysqli_query($connect,$query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($connect), E_USER_ERROR);

if(mysqli_query($connect,$query))
{

echo " Succesfully update";

}
else
{
echo "Try again Later ..." .mysqli_error($connect) ;

}

?>
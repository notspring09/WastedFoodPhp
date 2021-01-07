<?php
require "../connection.php";
$receiver_id = $_POST["receiver_id"];

$query = "update `notification` set 
`notification`.`seen` = TRUE
where `notification`.`receiver_id` = '$receiver_id'";

// $result = mysqli_query($connect,$query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($connect), E_USER_ERROR);
if(mysqli_query($connect,$query))
{

echo " Succesfully update";

}
else
{
echo "Try again Later ..." ;
}
?>

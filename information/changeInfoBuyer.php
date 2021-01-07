<?Php
require "../connection.php";
// $account_id = 3013;
// $name = "Nguyen Ngoc Anh";
// $phone = "023231212";
// $urlImage = null;
// $dob = null;
// $gender = 0;

$account_id = $_POST['account_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$urlImage = $_POST['urlImage'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];

$account_id = mysqli_real_escape_string($connect, $account_id);
$name = mysqli_real_escape_string($connect, $name);
$phone = mysqli_real_escape_string($connect, $phone);
$urlImage = mysqli_real_escape_string($connect, $urlImage);
$dob = mysqli_real_escape_string($connect, $dob);
$gender = mysqli_real_escape_string($connect, $gender);

$query1 = "UPDATE `buyer` SET `date_of_birth`='$dob',
`name`='$name',
`gender`= $gender ";
if($urlImage!=" ")
$query1 = $query1 . ",`image`='$urlImage'";

$query1 = $query1 .  " WHERE `account_id` = $account_id";

$result = $connect->query($query1);
$query2 = "UPDATE `account` SET `phone` = '$phone' WHERE `id` = $account_id";
$result = $connect->query($query2);

if(mysqli_query($connect, $query1)){
 
}else{
    echo "failed1";
    exit();
}
if(mysqli_query($connect, $query2)){

}else{
    echo "failed2";
    exit();
}

?>
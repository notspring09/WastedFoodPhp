<?php
require "../connection.php";

$receiver_id = $_REQUEST["receiver_id"];

//query
$query = "select notification.id,notification.sender_id ,notification.receiver_id ,
notification.content , notification.modified_date , notification.order_id ,
 seller.image AS seller_image , buyer.image as buyer_image , seller.name as seller_name ,
  buyer.name as buyer_name , product.name as product_name, product.image as product_image 
  FROM notification INNER JOIN buyer on notification.receiver_id = buyer.account_id INNER JOIN 
  seller on notification.sender_id = seller.account_id INNER JOIN `order` AS OD 
  on notification.order_id = OD.id INNER JOIN product ON OD.product_id = product.id 
  WHERE notification.receiver_id = $receiver_id order BY notification.modified_date desc" ;

$result = $connect->query($query);

//Class notification
class Notification
{
    function Notification($id, $sender_id, $receiver_id, $content, $modified_date, 
    $order_id, $seller_image, $buyer_image, $seller_name, $buyer_name, $product_name , $product_image)
    {
        $this->id = $id;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->content = $content;
        $this->modified_date = $modified_date;
        $this->order_id = $order_id;
        $this->seller_image = $seller_image;
        $this->buyer_image = $buyer_image;
        $this->seller_name = $seller_name;
        $this->buyer_name = $buyer_name;
        $this->product_name = $product_name;
        $this->product_image = $product_image;
    }
}

//Create array
$listOrder = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($listOrder, new Notification($row['id'], $row['sender_id'], $row['receiver_id']  , $row['content'] ,  $row['modified_date'], $row['order_id'],
     $row['seller_image'], $row['buyer_image'], $row['seller_name'], $row['buyer_name'], $row['product_name'], $row['product_image']));
}

//change array to json
echo json_encode($listOrder);






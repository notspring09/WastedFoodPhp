<?php

class Order
{
    public $id;
    public $buyer_id;
    public $product_id;
    public $quantity;
    public $status;
    public $total_cost;
    public $buyer_comment;
    public $product;

    public function __construct($id, $buyer_id, $product_id, $quantity, $status, $total_cost, $buyer_comment, $product)
    {
        $this->id = $id;
        $this->buyer_id = $buyer_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->status = $status;
        $this->total_cost = $total_cost;
        $this->buyer_comment = $buyer_comment;
        $this->product = $product;
    }
}

<?php
class Product
{
    public $id;
    public $seller_id;
    public $name;
    public $image;
    public $start_time;
    public $end_time;
    public $original_price;
    public $sell_price;
    public $original_quantity;
    public $remain_quantity;
    public $description;
    public $sell_date;
    public $status;
    public $shippable;
    public $seller;
    
    function __construct($id, $seller_id, $name, $image, $start_time, $end_time, $original_price, $sell_price, $original_quantity, $remain_quantity, $description, $sell_date, $status, $shippable,$seller)
    {
        $this->id = $id;
        $this->seller_id = $seller_id;
        $this->name = $name;
        $this->image = $image;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->original_price = $original_price;
        $this->sell_price = $sell_price;
        $this->original_quantity = $original_quantity;
        $this->remain_quantity = $remain_quantity;
        $this->description = $description;
        $this->sell_date = $sell_date;
        $this->status = $status;
        $this->shippable = $shippable;
        $this->seller = $seller;
    }
}

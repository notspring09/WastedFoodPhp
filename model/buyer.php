<?php
require "account.php";
class Buyer extends Account{
    public $name;
    public $date_of_birth;
    public $image;
    public $gender;

    function __construct($id,$role_id,$username,$password,$phone,$third_party_id,$email,$create_date,$is_active,$firebase_UID,$name,$date_of_birth,$image,$gender)
    {
        parent::__construct($id,$role_id,$username,$password,$phone,$third_party_id,$email,$create_date,$is_active,$firebase_UID);
        $this->name=$name;
        $this->date_of_birth = $date_of_birth;
        $this->image =$image;
        $this->gender = $gender;
    }
}
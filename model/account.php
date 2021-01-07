<?php


class Account
{
    public $id;
    public $role_id;
    public $username;
    public $password;
    public $phone;
    public $third_party_id;
    public $email;
    public $create_date;
    public $is_active;
    public $firebase_UID;
    function __construct($id, $role_id, $username, $password, $phone, $third_party_id, $email, $create_date, $is_active, $firebase_UID)
    {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->username = $username;
        $this->password = $password;
        $this->phone = $phone;
        $this->third_party_id = $third_party_id;
        $this->email = $email;
        $this->create_date = $create_date;
        $this->is_active = $is_active;
        $this->firebase_UID = $firebase_UID;
    }
    
}

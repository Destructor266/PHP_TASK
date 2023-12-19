<?php
class User
{
    protected $id;
    protected $username;
    protected $email;
    protected $password;


    public function __construct($id, $username, $email, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
}
?>
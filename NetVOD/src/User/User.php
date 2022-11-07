<?php

namespace NetVOD\User;

class User
{
    private string $email;
    private string $passwd;

    public function __construct($email, $passwd)
    {
        $this->email = $email;
        $this->passwd = $passwd;
    }

    public function __get(string $at):mixed {
        if (property_exists ($this, $at)) return $this->$at;
        else throw new \Exception ("$at: invalid property");
    }
    

    public function __set(string $at,mixed $val):void {
        if ( property_exists ($this, $at) ) $this->$at = $val;
        else throw new \Exception ("$at: invalid property");
    }

}
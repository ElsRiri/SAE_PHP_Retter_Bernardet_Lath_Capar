<?php

namespace NetVOD\User;

use NetVOD\db\ConnectionFactory;

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

    public function getPreference():array{
        $listVidePref = [];

        $sql = "SELECT id_serie FROM preference";
        $res = ConnectionFactory::$db->prepare($sql);
        $res->execute();

        while ($data = $res->fetch()){
            array_push($listVidePref,$data[0]);
        }

        return $listVidePref;
    }

}
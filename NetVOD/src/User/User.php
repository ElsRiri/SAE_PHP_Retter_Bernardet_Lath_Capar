<?php

namespace NetVOD\User;

use NetVOD\db\ConnectionFactory;
use NetVOD\video\Serie;

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
        $sql = "SELECT serie.id, serie.titre
            from serie, preference, user
            where serie.id=preference.id_serie 
            and user.id= preference.id_user
            and user.email='{$this->email}'";
        $res = ConnectionFactory::$db->prepare($sql);
        $res->execute();

        $serie = Serie::class;

        while ($data = $res->fetch()){
            $serie = new Serie($data[0],$data[1]);
            array_push($listVidePref,$serie);
        }

        return $listVidePref;
    }

    public function getId():int{
        $id=0;

        $sql = "SELECT id FROM user WHERE email='{$this->email}'";
        $res = ConnectionFactory::$db->prepare($sql);
        $res->execute();

        while ($data = $res->fetch()){
            $id = $data[0];
        }

        return $id;
    }

}
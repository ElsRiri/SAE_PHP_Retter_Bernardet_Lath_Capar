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
}
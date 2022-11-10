<?php

namespace NetVOD\action;

use NetVOD\Auth\Auth;

class DeconnexionAction extends Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            session_unset();
        }
        return $html;
    }
}
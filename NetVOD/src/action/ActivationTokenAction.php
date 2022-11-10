<?php

namespace NetVOD\action;

use NetVOD\Auth\Auth;

class ActivationTokenAction extends Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $token = $_GET['token'];
            $html = <<<END
                <form id="validerCompte" method="post" action="index.php?action=activationToken&token=$token">
                <input class="button" name="valider le compte" value="valid" type="submit">
                </form>
            END;
            return $html;
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {     
            $verif = Auth::activate($_GET['token']);
            if ($verif==true){
                $html .= <<<END
                
                END;
            }
        }
        return $html;

    }
}
<?php

namespace NetVOD\action;

use NetVOD\Auth\Auth;

class IdentificationAction extends \NetVOD\action\Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $html = <<<END
            <form id="connexion" method="post" action="index.php?action=identification">
                <label>Email : </label>
                <input name="email" type="email" placeholder="<email>">
                <label>Mot de passe : </label>
                <input name="password" type="password" placeholder="<password>">
                <button type="submit">valider</button>
            </form>
            <a href='?action=mdpOublie'>Mot de passe oublié ?</a>
END;
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

            $us = Auth::authenticate($_POST['email'], $_POST['password']);
            if (is_null($us)) {
                $html = "Ces informations ne vous ont pas permis de vous authentifier";
            }

        }
        return $html;

    }
}
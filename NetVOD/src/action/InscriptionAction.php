<?php

namespace NetVOD\action;

class InscriptionAction extends Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $html = <<<END
<form id="inscription" method="post" action="principal.php?action=add-user">
<label>Email : </label>
<input name="email" type="email" placeholder="<email>">
<label>Mot de passe : </label>
<input name="password" type="password" placeholder="<password>">
<button type="submit">valider</button>
</form>
END;
            return $html;
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

            Auth/A ($_POST['email'], $_POST['password']);
        }
        return $html;

    }
}
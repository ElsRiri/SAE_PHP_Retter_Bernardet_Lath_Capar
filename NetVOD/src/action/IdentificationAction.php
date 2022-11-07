<?php

namespace NetVOD\action;

class IdentificationAction extends \NetVOD\action\Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $html = <<<END
<form id="connexion" method="post" action="principal.php?action=signin">
<label>Email : </label>
<input name="email" type="email" placeholder="<email>">
<label>Mot de passe : </label>
<input name="password" type="password" placeholder="<password>">
<button type="submit">valider</button>
</form>
END;
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

            $us = \iutnc\deefy\auth\Auth\Auth::authenticate($_POST['email'], $_POST['password']);
            if (!is_null($us)) {
                $tab = $us->getPlaylists();
                foreach ($tab as $key => $value) {
                    $var = \iutnc\deefy\audio\lists\Playlist::find($value["id"]);
                    $var2 = new \iutnc\deefy\render\AudioListRenderer($var);
                    $str = $var2->render(1);
                    $html .= $str;
                }
            } else {
                $html = "Ces informations ne vous ont pas permis de vous authentifier";
            }
        }
        return $html;

    }
}
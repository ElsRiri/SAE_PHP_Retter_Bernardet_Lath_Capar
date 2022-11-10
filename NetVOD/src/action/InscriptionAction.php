<?php

namespace NetVOD\action;

use NetVOD\Auth\Auth;

class InscriptionAction extends Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $html = <<<END
            <form id="inscription" method="post" action="index.php?action=inscription">
            <label>Email : </label>
            <input name="email" type="email" placeholder="<email>">
            <label>Mot de passe : </label>
            <input name="password" type="password" placeholder="<password>">
            <button type="submit">valider</button>
            </form>
            END;
            return $html;
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $mail = $_POST['email'];
            $token = Auth::register($_POST['email'], $_POST['password']);
            if ($token=="Erreur : Mot de passe pas assez long (min : 10)"){
                $html .= <<<END
                    <p>$token</p>
                END;
            } elseif ($token == "Erreur : Email déjà utilisé"){
                $html .= <<<END
                    <p>$token</p>
                END;
            }else{
                $html .= <<<END
                
                <a href=index.php?action=activationToken&email=$mail&token=$token><strong><FONT size="120pt">Validation du compte !</FONT></strong></a>

                END;
            }
        }
        return $html;

    }
}
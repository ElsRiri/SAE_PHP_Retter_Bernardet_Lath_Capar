<?php

namespace NetVOD\action;

use NetVOD\Auth\Auth;

class MdpOublieAction extends Action
{

    public function execute(): string
    {
        $html = "";
        $email = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (isset($_GET['token']) && (isset($_GET['email']))){
                $email = $_GET['email'];
                $html = <<<END
                <form id="mdp2" method="post" action="index.php?action=mdpOublie&email=$email">
                    <label>Mot de passe : </label>
                    <input name="motdepasse" type="password" placeholder="<mot de passe>">
                    <button type="submit">valider</button>
                </form>
            END;
            }else{
                $html = <<<END
                <form id="mdp1" method="post" action="index.php?action=mdpOublie">
                    <label>Email : </label>
                    <input name="email" type="email" placeholder="<email>">
                    <button type="submit">valider</button>
                </form>
            END;
            return $html;
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {  
            foreach ($_GET as $key => $value) {
            }   
            foreach ($_POST as $key => $value) {
            }  
            if (isset($_POST['motdepasse'])){
                Auth::renewpswd($_POST['motdepasse'],$_GET['email']);
            }else{
            
            $mail = $_POST['email'];
            $token = Auth::enregistrerNewToken($mail);
            $html .= <<<END
            <a href='?action=mdpOublie&token=$token&email=$mail'>Nouveau mot de passe</a>
            END;
            }
        }
        return $html;

    }
}
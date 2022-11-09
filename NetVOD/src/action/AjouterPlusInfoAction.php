<?php

namespace NetVOD\action;

use NetVOD\db\ConnectionFactory;

class AjouterPlusInfoAction extends Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $html = <<< END
    <h2>Vous pouvez ici définir des informations supplémentaires</h2>
    
    <form id="plusinfo" method="post" action="index.php?action=ajouterinfo">
    <label>Prénom : </label>
    <input name="prenom" type="text" placeholder="<prénom>">
    <label>nom : </label>
    <input name="nom" type="text" placeholder="<nom>">
    
    <br><p>Vous devez mettre l'id de votre genre préféré</p>
    <br><p>Les différents genres sont :</p>
    <br>
    <ul>
    <li>1 : Drame</li>
    <li>2 : ASMR</li>
    <li>3 : Romance</li>
    <li>4 : Comédie</li>
    <li>5 : Thriller</li>
    <li>6 : Criminel</li>
    <li>7 : Horreur</li>
    <li>7 : Horreur</li>
    <li>8 : Fantasy</li>
    <li>9 : Catastrophe</li>
    <li>10 : Scicence Fi</li>
    </ul>
    <label>Genre(s) : </label>
    <input name="genre" type="number" placeholder="<genre(s)>">
    <button type="submit">valider</button>
    </form>
    END;
            return $html;

        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['genre'])){
                if($_POST['genre'] > 10 && $_POST['genre'] < 1){
                    return "Sélectionnez une id de genre valide !";
                }
                $pdo = ConnectionFactory::makeConnection();
                $co = $_SESSION['connexion'];
                $email = $co->email;

                $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
                $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);

                $stmtup = $pdo->prepare('UPDATE user SET nom = ?, prenom = ?, id_genre = ? WHERE email = ?');
                $stmtup->bindParam(1, $nom);
                $stmtup->bindParam(2, $prenom);
                $stmtup->bindParam(3, $_POST['genre']);
                $stmtup->bindParam(4, $email);
                $stmtup->execute();

            } else {
                return "Veuillez remplir tous les champs";
            }
        }
        return "Vos informations ont bien étaient ajoutée";
    }
}
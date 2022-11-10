<?php

namespace NetVOD\action;

use NetVOD\exception\AuthException;
use NetVOD\video\Catalogue;

class DisplayCatalogueAction extends Action
{

    public function __construct()
    {
        parent::__construct();
    }

    public function execute(): string
    {
        $html = "";

        if ($this->http_method == "GET") {
            if (!isset($_SESSION['connexion']->email)) {
                $catalogue = new Catalogue();


                $html = <<<END
                <form id="recherche" method="post" action="index.php?action=DisplayCatalogueAction">
                <label>Recherche : </label>
                <input name="recherche" type="text" placeholder="saisir mots...">
                    <select name="attribut" id="tri">
                        <option value="titre">titre</option>
                        <option value="date_ajout">date_ajout</option>
                        <option value="nb_episode">nb_episode</option>
                        <option value="annee">annee</option>
                         <option value="note">note</option>
                    </select>
                    <input type="radio" id="decroissant" name="tri" value="decroissant" checked>
                    <label for="annee">decroissant</label>
                    <input type="radio" id="croissant" name="tri" value="croissant">
                    <label for="annee">croissant</label>
                    <select name="genre" id="filtre_genre">
                    <option value="">Genre</option>
                    <option value="Drame">Drame</option>
                    <option value="ASMR">ASMR</option>
                    <option value="Romance">Romance</option>
                    <option value="Comedie">Comedie</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Criminel">Criminel</option>
                    <option value="Horreur">Horreur</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Catastrophe">Catastrophe</option>
                    <option value="Science-Fi">Science-Fi</option>
                </select>
                <select name="public" id="filtre_public">
                    <option value="">Public</option>
                    <option value="tout_public">tout public</option>
                    <option value="public_averti">public averti</option>
                    <option value="jeune_public">jeune public</option>
                </select>
                    <button type="submit">Envoyer</button>
                </form>
                {$catalogue->render()}
                END;


            } else {
                $html .= <<<END
                <p><strong>Vous ne pouvez pas afficher le catalogue sans vous connecter au préalable !</strong></p>
                END;
            }

        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $catalogue = new \NetVOD\video\Catalogue();
            if (isset($_POST['recherche']) && !empty($_POST['recherche'])) {
                $search = $_POST['recherche'];
                $catalogue->insertRecherche($search);
            }

            //tri le catalogue
            if (sizeof($catalogue->series)>=2 && isset($_POST['attribut']) && isset($_POST['tri'])) {
                $tri = $_POST['tri'];
                $attribut = $_POST['attribut'];
                $catalogue->tri($tri, $attribut);
            }

            //filtre 
            if (isset($_POST['genre'])) {
                $catalogue->filtre_genre($_POST['genre']);
            }
            
            if (isset($_POST['public'])) {
                $catalogue->filtre_public($_POST['public']);
            }

            $html = <<<END
                <form id="recherche" method="post" action="index.php?action=DisplayCatalogueAction">
                <label>Recherche : </label>
                <input name="recherche" type="text" placeholder="saisir mots...">
                    <select name="attribut" id="tri">
                        <option value="titre">titre</option>
                        <option value="date_ajout">date_ajout</option>
                        <option value="nb_episode">nb_episode</option>
                        <option value="annee">annee</option>
                        <option value="note">note</option>
                    </select>
                    <input type="radio" id="decroissant" name="tri" value="decroissant" checked>
                    <label for="annee">decroissant</label>
                    <input type="radio" id="croissant" name="tri" value="croissant">
                    <label for="annee">croissant</label>
                    <select name="genre" id="filtre_genre">
                    <option value="">Genre</option>
                    <option value="Drame">Drame</option>
                    <option value="ASMR">ASMR</option>
                    <option value="Romance">Romance</option>
                    <option value="Comedie">Comedie</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Criminel">Criminel</option>
                    <option value="Horreur">Horreur</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Catastrophe">Catastrophe</option>
                    <option value="Science-Fi">Science-Fi</option>
                </select>
                <select name="public" id="filtre_public">
                    <option value="">Public</option>
                    <option value="tout_public">tout public</option>
                    <option value="public_averti">public averti</option>
                    <option value="jeune_public">jeune public</option>
                </select>
                    <button type="submit">Envoyer</button>
                </form>
                {$catalogue->render()}
            END;

        }

        return $html;
    }


}
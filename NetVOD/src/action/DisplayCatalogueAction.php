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

                //tri le catalogue
                if (isset($_GET['attribut']) && isset($_GET['tri'])) {
                    $tri = $_GET['tri'];
                    $attribut = $_GET['attribut'];
                    $catalogue->tri($tri, $attribut);
                }

                $html = <<<END
                <form id="recherche" method="post" action="index.php?action=DisplayCatalogueAction">
                <label>Recherche : </label>
                <input name="recherche" type="text" placeholder="saisir mots...">
                </form>
                <form id="tri" method="post" action="index.php?action=DisplayCatalogueAction"> 
                    <select name="attribut" id="tri">
                        <option value="titre">titre</option>
                        <option value="date_ajout">date_ajout</option>
                        <option value="nb_episode">nb_episode</option>
                        <option value="annee">annee</option>
                    </select>
                    <input type="radio" id="decroissant" name="tri" value="decroissant" checked>
                    <label for="annee">decroissant</label>
                    <input type="radio" id="croissant" name="tri" value="croissant">
                    <label for="annee">croissant</label>
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
            $search = $_POST['recherche'];

            $catalogue = new \NetVOD\video\Catalogue();
            $catalogue->insertRecherche($search);
            $html = <<<END
                <form id="recherche" method="post" action="index.php?action=DisplayCatalogueAction">
                <label>Recherche : </label>
                <input name="recherche" type="text" placeholder="saisir mots...">
                </form>
                {$catalogue->render()}
            END;

            header('Location: http://localhost/sae/NetVOD/index.php?action=DisplayCatalogueAction' . '&attribut=' . $_POST['attribut'] . '&tri=' . $_POST['tri']);
        }

        return $html;
    }


}
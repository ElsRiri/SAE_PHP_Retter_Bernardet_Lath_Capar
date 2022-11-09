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
                //query string pour le tri
                $trie = "";
                if (isset($_GET['trie'])) {
                    $trie = "&trie=" . $_GET['trie'];
                }
                $
                $html = <<<END
                <form id="trie" method="post" action="index.php?action=DisplayCatalogueAction$trie"> 
                    <input type="radio" id="titre1" name="trie" value="titre"> 
                    <label for="titre1">titre</label>
                    <input type="radio" id="date_ajout" name="trie" value="date_ajout"> 
                    <label for="date_ajout">date ajout</label>
                    <input type="radio" id="nbEpisode" name="trie" value="nombre_episode">
                    <label for="nbEpisode">nombre episode</label>
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


        }
        return $html;
    }


}
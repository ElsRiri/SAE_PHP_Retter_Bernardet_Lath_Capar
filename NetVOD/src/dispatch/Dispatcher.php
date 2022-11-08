<?php

namespace NetVOD\dispatch;

use NetVOD\User\User;

class Dispatcher
{
    private $action;

    public function __construct($action)
    {
        $this->action = $action;
    }


    public function run(): void
    {
        switch ($this->action) {
            case 'DisplaySerieAction':
                $stmt = new \NetVOD\action\DisplaySerieAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;
            case 'DisplayCatalogueAction':
                $stmt = new \NetVOD\action\DisplayCatalogueAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;
            
            case 'DisplayEpisode':
                $stmt = new \NetVOD\action\DisplayEpisode();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            case 'identification':
                $stmt = new \NetVOD\action\IdentificationAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            case 'inscription':
                $stmt = new \NetVOD\action\InscriptionAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            case 'DisplaySerieEnCoursAction':
                $stmt = new \NetVOD\action\DisplaySerieEnCoursAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            default :
                $str = "<H1>Bienvenue sur Netvod</H1>";
                if(isset($_SESSION['connexion'])){
                    $str.= 'vous etes connecté, '.$_SESSION['connexion']->email;
                }else{
                    $str.= 'vous etes pas connecté';
                }
                $this->renderPage($str);
                break;
        }


    }

    private function renderPage(string $html): void
    {
        $co = "";
        if (isset($_SESSION['connexion'])){
            $tPREF = $_SESSION['connexion']->getPreference();
            $string = "<ul>";
            foreach ($tPREF as $t => $v) {
                $string .= <<<END
                <li><a href="index.php?action=DisplaySerieAction&idserie=$v->id">$v->titre</a></li>
                END;
            }
            $string .= "</ul>";
            $co = <<<END
            <li><a href="index.php?action=DisplayCatalogueAction">Affichage du catalogue</a></li><BR>
            <li><a href="index.php?action=DisplaySerieEnCoursAction">Vos série en cours</a></li><BR>
            $string

            END;
        }
        echo <<<END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NetVOD</title>
</head>
<body>
<h1>NetVOD</h1>
<nav>
<ul>
<li><a href="index.php">Accueil</a></li>
<li><a href="index.php?action=inscription">Inscription</a></li>
<li><a href="index.php?action=identification">Connexion</a></li>
$co
</ul>
</nav>
$html
</body>
</html>
END;
    }
}
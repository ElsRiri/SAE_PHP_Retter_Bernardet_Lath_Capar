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

            case 'ajouterinfo':
                $stmt = new \NetVOD\action\AjouterPlusInfoAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;
            case 'DisplayCommentaire':
                $stmt = new \NetVOD\action\DisplayCommentaire();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            case 'activationToken':
                $stmt = new \NetVOD\action\ActivationTokenAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            case 'DisplaySerieTermine':
                $stmt = new \NetVOD\action\DisplaySerieTermine();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            case 'mdpOublie':
                $stmt = new \NetVOD\action\MdpOublieAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            case 'deconnexion':
                "oui";
                $stmt = new \NetVOD\action\DeconnexionAction();
                $str = $stmt->execute();
                $this->renderPage($str);
                break;

            default :
                $str = "<H1>Bienvenue sur Netvod</H1><br>";
                $stmt = new \NetVOD\action\DisplayProfileAction();
                $str .= $stmt->execute();
                $this->renderPage($str);
                break;
        }


    }

    private function renderPage(string $html): void
    {
        $co = "";
        if (isset($_SESSION['connexion'])){
            $tPREF = $_SESSION['connexion']->getPreference();
            $string = "<h3>Séries preférées</h3><ul class = 'test'>";
            foreach ($tPREF as $t => $v) {
                $string .= <<<END
                <li><a href="index.php?action=DisplaySerieAction&idserie=$v->id">$v->titre</a></li>
                END;
            }
            $string .= "</ul>";
            $co = <<<END
            <li><a href="index.php?action=deconnexion">Déconnexion</a></li><BR>
            <li><a href="index.php?action=DisplayCatalogueAction">Affichage du catalogue</a></li><BR>
            <li><a href="index.php?action=DisplaySerieEnCoursAction">Vos séries en cours</a></li><BR>
            <li><a href="index.php?action=DisplaySerieTermine">Vos séries terminées</a></li><BR>
            <li><a href="index.php?action=ajouterinfo">Ajouter information à votre profil</a></li><BR>
            $string

            END;
        }
        echo <<<END
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" />
    <title>NetVOD</title>
</head>
<body>
<h1 class ="notreh1">NetVOD</h1>
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
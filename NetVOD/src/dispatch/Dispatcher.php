<?php

namespace NetVOD\dispatch;

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

            default :
                $str = "<H1>Netvod</H1>";
                $this->renderPage($str);
                break;
        }


    }

    private function renderPage(string $html): void
    {
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
</ul>
</nav>
$html
</body>
</html>
END;
    }
}
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
<li><a href="principal.php">Accueil</a></li>
<li><a href="principal.php?action=add-user">Inscription</a></li>
<li><a href="principal.php?action=signin">Connexion</a></li>
</ul>
</nav>
$html
</body>
</html>
END;
    }
}
<?php
namespace NetVOD\action;

use NetVOD\action\Action;
use NetVOD\exception\AuthException;
use NetVOD\video\Catalogue;

class DisplayCatalogueAction extends Action {

    public function __construct(){
        parent::__construct();
    }

    public function execute() : string{
        $html = "";
        
        if ($this->http_method=="GET") {
            if (isset($_SESSION['connexion']['email'])){
                $catalogue = new Catalogue();
                $html = <<<END
                {$catalogue->render()}
                END;
            }else{
                $html .= <<<END
                <p><strong>Vous ne pouvez pas afficher le catalogue sans vous connecter au préalable !</strong></p>
                END;
            }
            return $html;
        }
    }

}
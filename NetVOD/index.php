<?php
require_once 'vendor/autoload.php';
session_start();

try{
    \NetVOD\db\ConnectionFactory::setConfig('db.ini');
    $db = \NetVOD\db\ConnectionFactory::makeConnection();
}catch (Error $ignored){
    echo "problème avec la base de donnée.";
}


$action = null;
$html = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
$disp = new \NetVOD\dispatch\Dispatcher($action);
$disp->run();
<?php
require_once 'vendor/autoload.php';
\NetVOD\db\ConnectionFactory::setConfig('db.config.ini');
$db = \NetVOD\db\ConnectionFactory::makeConnection();

$action = null;
$html = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
$disp = new \NetVod\dispatch\Dispatcher($action);
$disp->run();
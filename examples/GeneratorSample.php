<?php
require '../vendor/autoload.php';
/**
 * Created by PhpStorm.
 * User: Adebola
 * Date: 11/26/2015
 * Time: 3:44 AM
 */

$oExample = new Samcrosoft\UIFaces\Generators();
//$oUser = $oExample->getRandomUser();
//$aUsers = $oExample->getBatchUsers(5);
$oUserSpecific = $oExample->getUser('calebogden');
var_dump($oUserSpecific);
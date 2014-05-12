<?php

require __DIR__ . '/src/SMSShooter.php';
$array = require __DIR__ . '/src/ipAddress.php';

$sms = new SMSShooter();

$server = $_SERVER['REMOTE_ADDR'];

if(!((substr($server,0,strrpos ($server, ".")) == "192.168.0") || (in_array($server, $array)))){
    addIp($server);
    die("otario");
}

if(isset($_GET["numero"]) && isset($_GET['mensagem'])){
    $sms->send($_GET['numero'], $_GET['mensagem']);

}else if(isset($_POST["numero"]) && isset($_POST["mensagem"])){
    $sms->send($_POST['numero'], $_POST['mensagem']);

}else if(isset($argv[1]) && isset($argv[2])){
    $sms->send($argv[1], $argv[2]);
}

function addIp($server){
    $banned = fopen("banned.php", "w");
    fwrite($banned,$server . "\n");
    fclose($banned);
}
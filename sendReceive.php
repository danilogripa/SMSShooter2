<?php

require __DIR__ . '/src/SMSShooter.php';

$sms = new SMSShooter;

if($smslist = $sms->receive()){
	foreach($smslist as $file){
		if(strtoupper($file['mensagem']) == "TESTE"){
			$sms->send($file['numero'], "Resposta OK!");
		}
		if(strtoupper($file['mensagem']) == "REBOOT"){
			shell_exec("reboot");
		}
	}
}else{
	die();
}

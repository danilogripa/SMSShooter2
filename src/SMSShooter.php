<?php

/*
 *
 * Banco de dados
 * id, number, message, priority, modem, saveDate, sendDate
 *
 */

class SMSShooter {


    public $number;
    public $message;
    public $priority;

    public function __construct($number = null, $message = null, $priority = null) {
        $this->message = $message;
        $this->number = $number;
        $this->priority = $priority;
    }

    public function startsWith($haystack, $needle){
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
    public function removeStarts($number){
        if($this->startsWith($number, "0")){
            return substr($number,1);
        }
        return $number;
    }
    public function validNumber($number){
        $number = $this->removeStarts($number);
        if(strlen($number) == 10){
            $number = substr($number, 1, 2) . "9" . substr($number,-8);
        }
        if(strlen($number) == 11){
            $number = "+55". $number;
        }
        return $number;
    }
    public function validMessage($message){
        $message = str_replace('"', '', $message);
        $message = str_replace("'", "", $message);
        $message = str_replace(";" , "" , $message);
        return $message;
    }
    public function send($number = null, $message = null, $priority = null){

        $number = $this->validNumber($number);
        $message = $this->validMessage($message);
        if($priority == null){$priority = "5";}
        $filename = rand(100,999) . "." . date("Y-m-d.H:i:s") . "." . $priority;
        $dongle = 'dongle0';

        $file = <<<HEREDOC

Channel: LOCAL/SMSShooter@smssend
Application: Playback
Data: silence/1&tt-weasels
SetVar: dongle=$dongle
SetVar: numero=$number
SetVar: mensagem="$message"
Archive: yes
HEREDOC;

	$fh = fopen(__DIR__ . "/../tmp/send/" . $filename . ".call", "w");
        fwrite($fh, $file);
        fclose($fh);

	$file = date("Y-m-d H:i:s") . " $dongle $number $message";
	$fh = fopen(__DIR__ . "/../log/send/sms.txt", "w");
        fwrite($fh, $file);
        fclose($fh);
    }

}

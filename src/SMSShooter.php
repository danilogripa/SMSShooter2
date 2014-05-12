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

//    public function send(){}
//    public function send($number, $message, $priority = null){}
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
Channel: LOCAL/smssend@smssend
Application: DongleSendSMS
Data: $dongle,$number,$message
HEREDOC;

        $fh = fopen("/var/tmp/". $filename . ".call" , 'w');
        fwrite($fh, $file);
        fclose($fh);
    }

}

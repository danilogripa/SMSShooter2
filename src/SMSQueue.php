<?php
/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 02/05/14
 * Time: 13:36
 */

class SMSQueue {

    public $number;
    public $message;
    public $priority;

    public function __construct($number = null, $message = null, $priority = null) {
        $this->message = $message;
        $this->number = $number;
        $this->priority = $priority;
    }


    public function saveToPool(){}

    public function checkPool(){}

    public function removeFromPool(){}

} 
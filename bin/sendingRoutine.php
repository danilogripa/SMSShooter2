<?php
/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 11/05/14
 * Time: 14:20
 */

$command = "mv " . __DIR__ . "/../tmp/send/* /var/spool/asterisk/outgoing/";
$output = shell_exec("$command ");

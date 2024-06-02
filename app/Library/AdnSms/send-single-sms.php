<?php

require_once(__DIR__."/lib/AdnSmsNotification.php");

use AdnSms\AdnSmsNotification;

$message = "Congratulation!!
Al Helal Academy, Sonagazi
";


$recipient="8801840241895";     
$requestType = 'SINGLE_SMS';    
$messageType = 'TEXT';         

$sms = new AdnSmsNotification();
//$sms->sendSms($requestType, $message, $recipient, $messageType);

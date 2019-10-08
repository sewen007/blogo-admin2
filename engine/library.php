<?php

class library {

    public $databaseInstance = null;

    public function __construct() {
        $this->databaseInstance = new db();
    }

    public function sendSlackMessage($message, $channel = null) {
        $params = array('payload' => json_encode(array(
            'text' => $message)));
        
        if ($channel != null){
            $params = array('payload' => json_encode(array(
            'text' => $message, 
            'channel' => $channel)));
        }

        // Use curl to send your message
        $c = curl_init("https://hooks.slack.com/services/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");
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $params);
        curl_exec($c);
        curl_close($c);
        
        return true;
    }
    
    public function sendEmail($recipient, $subject, $message){
        mail($recipient, $subject, $message, "From: DiamondScripts Info <info@diamondscripts.ng>");
    }
}

?>
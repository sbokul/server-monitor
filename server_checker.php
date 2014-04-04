<?php
error_reporting(0);
ini_set("display_errors", 0);
session_start();
require_once("include/class.MySQL.php");
require_once('include/config.php');
require 'vendor/autoload.php';
use Mailgun\Mailgun;

function check($host, $port) {
    $fp = @fsockopen($host, $port, $errno, $errstr, 10);
    if (!$fp) {
        //echo "$errstr ($errno)\n";
        return false;
    } else {
        fclose($fp);
        return true;
    }
}

function alert($host, $server_name, $provider_email) {
    $mg = new Mailgun("key-35nnmiuxrw9vwg-ocgthgy4jztyk8b34");
    $email_from = 'server_notification@aestheticpeople.com';
    $to = 'shakil.bokul@gmail.com';
    $subject = $server_name.' ('.$host.') Down';

    $message = $server_name.' ('.$host.') Down';

    $domain = "aestheticpeople.com";

    # Now, compose and send your message.
    $result = $mg->sendMessage($domain, array('from' => 'Server Notification <server_notification@aestheticpeople.com>',
        'to' => $to,
        'subject' => $subject,
        'text' => $message));
    if(!empty($provider_email)) {
        $message2 = "Your network 100% Timed out, pls check and revert to me \nRegards \nNOC";
        $result2 = $mg->sendMessage($domain, array('from' => 'Server Notification <server_notification@aestheticpeople.com>',
            'to' => $provider_email,
            'subject' => $subject,
            'text' => $message2));
    }

    if($result2->http_response_code == 200) {
        return true;
    }
    return false;
}

$MySQL = new MySQL(DB_NAME, USER_NAME, PASSWORD, HOST);
$results = $MySQL->Select('servers');

foreach($results as $result) {
    $id = $result['id'];
    $server_name = $result['server_name'];
    $host = $result['ip_address'];
    $port = $result['port'];
    $mail_status = $result['mail_status'];

    if($port == null)
        $port = 80;

    $email = $result['email'];
    if (!check($host, $port)) {
        $var = array(
            'status' => 0
        );
        $where = array(
            'id' => $id
        );
        $MySQL->Update('servers', $var, $where);
        echo $server_name. ' ('.$host.')' .' Down'."\n";
        $alert_status = 0;
        if($mail_status == 0)
            $alert_status = alert($host, $server_name, $email);
        if($alert_status == true) {
            $var = array(
                'mail_status' => 1
            );
            $where = array(
                'id' => $id
            );
            $MySQL->Update('servers', $var, $where);
        }
    } else {
        $var = array(
            'status' => 1,
            'mail_status' => 0
        );
        $where = array(
            'id' => $id
        );
        $MySQL->Update('servers', $var, $where);
        echo $server_name. '('.$host.')' .' Up'."\n"; //
    }
}
?>
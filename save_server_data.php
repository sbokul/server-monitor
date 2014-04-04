<?php
error_reporting(0);
ini_set("display_errors", 0);
session_start();
require_once("include/class.MySQL.php");
require_once('include/config.php');
$MySQL = new MySQL(DB_NAME, USER_NAME, PASSWORD, HOST);
$serverName = $_POST['serverName'];
$ipAddress = $_POST['ipAddress'];
$port = $_POST['port'];
$provider = $_POST['provider'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$vars = array(
    'server_name' => $serverName,
    'ip_address' => $ipAddress,
    'port' => $port,
    'provider' => $provider,
    'email' => $email,
    'phone' => $phone,
    'status' => 0,
    'create_date' => date('Y-m-d')
);
$result = $MySQL->Insert($vars, 'servers');

if($result) {
    echo 1;
    $_SESSION['msg'] = 'Data Saved Successfully.';
    $_SESSION['status'] = 1;
} else {
    echo 0;
    $_SESSION['msg'] = 'Failed to save data.';
    $_SESSION['status'] = 0;
}
?>
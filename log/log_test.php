<?php
error_reporting(0);
ini_set("display_errors", 0);
session_start();
require_once("../include/class.MySQL.php");
require_once('../include/config.php');
$MySQL = new MySQL(DB_NAME, USER_NAME, PASSWORD, HOST);
$user_name = $_POST['user_name'];
$password = md5($_POST['password']);

$where = array(
    'user_name' => $user_name,
    'password' => $password
);

$result = $MySQL->Select('users', $where);

if(isset($result['user_name']))
{
	$_SESSION["user_name"] = $result['user_name'];
	$_SESSION["id"]= $result['id'];
	header("Location: ../dashboard.php");
	die();
}
else
	{
        $msg="Wrong User Name/Password Try Again";
        $msg=base64_encode($msg);
        header("Location: ../index.php?warn=$msg");
        die();
    }
?>
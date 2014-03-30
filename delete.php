<?php
error_reporting(0);
ini_set("display_errors", 0);
session_start();
require_once("include/class.MySQL.php");
require_once('include/config.php');
$MySQL = new MySQL(DB_NAME, USER_NAME, PASSWORD, HOST);
$id = $_GET['id'];
$where = array(
    'id' => $id
);
$result = $MySQL->Delete('servers', $where);
$msg="Record Deleted Successfully.";
$msg=base64_encode($msg);
header("Location: dashboard.php?msg=$msg");
die();
?>
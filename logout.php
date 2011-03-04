<?php

$guid = $_COOKIE['followingme_userid'];
@ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
$db->query("set names utf8");
$remove_cookie = "delete from cookies where GUID = '$guid'";
$db->query($remove_cookie);
$db->close(); 
setcookie('userid', '', time() + 157680000);
session_start();
session_destroy();
header('Location: index.php');

?>
<?php

session_start();
$user_id = $_SESSION['user_id'];
$user_lastfive = 'last-five_' . $user_id;
$user_followingme = 'followingme_' . $user_id;
if (apc_exists($user_id)) {
  apc_delete($user_id);
  apc_delete($user_lastfive);
  apc_delete($user_followingme);
}
@ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
$db->query("set names utf8");
$delete_users = "delete from users where user_id = '$user_id'";
$db->query($delete_users);
$delete_followers = "delete from followerlist where user_id = '$user_id'";
$db->query($delete_followers);
$delete_cookies = "delete from cookies where user_id = '$user_id'"; 
$db->query($delete_cookies);
header('Location: logout.php');

?>
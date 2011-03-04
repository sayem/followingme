<?php

session_start();
$user_id = $_SESSION['user_id'];
$update = $_POST['change-email'];
if ((strlen($update) > 60) || (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', trim($update)))) {
   $_SESSION['update'] = "<div id='email-update' class='red'>invalid email address</div>";
}
else {
  @ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
  $db->query("set names utf8");
  $update_email = "update users set email = '$update' where user_id = '$user_id'";
  $db->query($update_email);
  $_SESSION['update'] = "<div id='email-update' class='green'>updated</div>";
}
include('options.php');

?>
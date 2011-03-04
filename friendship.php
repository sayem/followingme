<?php

$user_a = $_POST['1'];
$user_b = $_POST['2'];

if ((strlen($user_a) <= 15) && (strlen($user_b) <= 15)) {
   if (! preg_match('/^[\w]+$/', trim($user_a).trim($user_b))) {
     $friendship = 'fail whale...';
   }
   else {
     $friend_check = simplexml_load_file("http://twitter.com/friendships/exists.xml?user_a=$user_a&user_b=$user_b");   
     if (! $friend_check) {
       $friendship = 'fail whale...';
     }
     else {
       $following = $friend_check[0];
	if ($following == 'true') {
	  $friendship = 'yup';
	}
	else if ($following == 'false') {
	  $friendship = 'nope';
	}
	else {
	  $friendship = 'fail whale...';
	}
     }
   }
}
else {
  $friendship = 'fail whale...';
}

if ($friendship == 'yup') { $friendship = "<div id='friendship-response' class='green'>yup</div>"; }
else if ($friendship == 'nope') { $friendship = "<div id='friendship-response' class='red'>nope</div>"; }
else { $friendship = "<div id='friendship-response' class='orange'>fail whale...</div>"; }
session_start();
if (isset($user_id) || isset($_SESSION['access_token'])) {
  $_SESSION['friendship'] = $friendship; 
  header('Location: index.php');
  exit;
}
else { include('home.inc'); }

?>
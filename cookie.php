<?php

@ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
$guid = $_COOKIE['userid'];
$cookie = "select user_id from cookies where GUID = '$guid'";
$cookie_query = $db->query($cookie);
$cookie_result = $cookie_query->fetch_array();
$user_id = $cookie_result[0];

if (!isset($user_id)) {
  header('Location: ./redirect.php');
  exit;
}
else {
  $users = "select * from users where user_id = '$user_id'";
  $user_query = $db->query($users);
  $user_result = $user_query->fetch_array();
  $oauth_token = $user_result['oauth_token'];
  $oauth_token_secret = $user_result['oauth_token_secret'];
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
}

?>
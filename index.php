<?php

session_start(); 
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$_SESSION['user_id'] = $access_token['user_id'];
$_SESSION['oauth_token'] = $access_token['oauth_token'];   
$_SESSION['oauth_token_secret'] = $access_token['oauth_token_secret'];

if (isset($_COOKIE['followingme_userid'])) {
  @ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
  $db->query("set names utf8");
  $guid = $_COOKIE['followingme_userid'];
  $cookie = "select user_id from cookies where GUID = '$guid'";
  $cookie_query = $db->query($cookie);
  $cookie_result = $cookie_query->fetch_array();
  $user_id = $cookie_result[0];
  if (!isset($user_id)) {
    if (isset($_SESSION['access_token'])) {
      include('signedin.inc');
    }
    else {
      include('home.inc');
      exit; 
    }
  }
  else {
    $users = "select * from users where user_id = '$user_id'";
    $user_query = $db->query($users);  
    $user_result = $user_query->fetch_array();
    $user_id = $user_result['user_id'];           
    $oauth_token = $user_result['oauth_token'];
    $oauth_token_secret = $user_result['oauth_token_secret'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    $_SESSION['user_id'] = $user_id;
    $_SESSION['oauth_token'] = $oauth_token;   
    $_SESSION['oauth_token_secret'] = $oauth_token_secret;
    include('signedin.inc');
    exit;
  }
}

if (!isset($_COOKIE['followingme_userid'])) {
  $guid = uniqid();
  setcookie('followingme_userid', $guid, time() + 157680000);
  if (isset($_SESSION['access_token'])) {
    include('signedin.inc');
  }
  else {
    include('home.inc');
    exit; 
  }
}

?>
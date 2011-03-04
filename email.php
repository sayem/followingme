<?php

session_start(); 
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
$access_token = $_SESSION['access_token'];
$user_id = $access_token['user_id'];
$oauth_token = $access_token['oauth_token'];
$oauth_token_secret = $access_token['oauth_token_secret'];
$screen_name = $access_token['screen_name'];
$email_address = $_POST['email_address'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
$follower_id = $_SESSION['follower_id']; 

if ((strlen($email_address) > 60) || (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i', trim($email_address)))) {
  $_SESSION['bad_email'] = 'invalid email address';
  include('email.inc');
  exit;
}
else {
  @ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
  $db->query("set names 'utf8'");
  $key = 'XXXX';
  $users = "insert into users (user_id, oauth_token, oauth_token_secret, screen_name, email) values ('$user_id', aes_encrypt('$oauth_token', '$key'), aes_encrypt('$oauth_token_secret', '$key'), '$screen_name', '$email_address')";
  $db->query($users);
  $guid = $_COOKIE['followingme_userid'];
  $cookies = "insert into cookies (GUID, user_id) values ('$guid', '$user_id')";    
  $db->query($cookies);
  $followerlist = "insert into followerlist (user_id, followers) values ('$user_id', '$follower_id')";
  $db->query($followerlist);
  $db->close();
  $follower_pic = $_SESSION['follower_pic'];
  $addfollower = $_SESSION['addfollower'];
  $user_followingme = 'followingme_' . $user_id;
  if (apc_exists($user_followingme)) {
    class Followingme {                      
      private $follower; private $follower_pic;
      function setfollower($value) {
	$this->follower = $value;
      }
      function setpic($value) {
	$this->follower_pic = $value;
      }
      function getfollower() {
	return $this->follower;
      }  
      function getpic() {
	return $this->follower_pic;
      }
    }
    $followingme = apc_fetch($user_followingme);
    $followers = $followingme->getfollower();
    $followers_pics = $followingme->getpic();
    if (!in_array($addfollower, $followers)) {
      array_push($followers, $addfollower); 
      array_push($followers_pics, $follower_pic);
      $followingme->setfollower($followers);
      $followingme->setpic($followers_pics);
      apc_store($user_followingme, $followingme, 900);
    }
  }
  include('welcome.php');    
  header('Location: index.php');
  exit;
}

?>
<?php

session_start();
$user_id = $_SESSION['user_id'];
$remove_name = $_POST['remove'];
require_once('twitteroauth/twitteroauth.php');   
require_once('config.php');
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

$follower = $connection->get('users/show', array('screen_name' => $remove_name));
$remove_id = $follower->id;  

@ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
$db->query("set names utf8");
$remove = "delete from followerlist where user_id = '$user_id' and followers = '$remove_id'";
$remove_query = $db->query($remove);

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
$user_followingme = 'followingme_' . $user_id;
$followingme = apc_fetch($user_followingme);
$followers = $followingme->getfollower();
$followers_pics = $followingme->getpic();
$key = array_search($remove_name, $followers);
if ($key >= 0) {
  unset($followers[$key]);
  unset($followers_pics[$key]);
  array_multisort($followers, $followers_pics);
  $followingme->setfollower($followers);
  $followingme->setpic($followers_pics);
  apc_store($user_followingme, $followingme, 900);
}

?>
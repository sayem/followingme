<?php

session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
$access_token = $_SESSION['access_token'];
$user_id = $access_token['user_id'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

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
if (apc_exists($user_followingme)) {
  $followingme = apc_fetch($user_followingme);
}
else {
  $followers = array();
  $followers_pics = array();
  $followers_ids = array();
  @ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
  $db->query("set names utf8");
  $follower_list = "select followers from followerlist where user_id = '$user_id'";
  $followers_result = $db->query($follower_list);
  while ($row = $followers_result->fetch_array()) {
    $follower_id = $row[0];
    $friend = $connection->get('users/show', array('user_id' => $follower_id));   
    $screen_name = $friend->screen_name;
    $pic = $friend->profile_image_url;
    array_push($followers, $screen_name);
    array_push($followers_pics, $pic);
    array_push($followers_ids, $follower_id);
  }
  $followingme = new Followingme;
  $followingme->setfollower($followers);
  $followingme->setpic($followers_pics);
  apc_add($user_followingme, $followingme, 900);
}

$followers = $followingme->getfollower();
$followers_pics = $followingme->getpic();
$followercount = count($followers);

for ($i=0; $i<$followercount; $i++) {
  print
"<li class='fm-list following'>
<img src='$followers_pics[$i]'/>
<div class='fm-names remove'>$followers[$i]</div>
</li>";
}

?>
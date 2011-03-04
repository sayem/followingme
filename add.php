<?php

session_start();
$user_id = $_SESSION['user_id'];
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$addfollower = $_POST['add'];
if (isset($_COOKIE['userid']) && (!isset($_SESSION['access_token']))) {
  require_once('cookie.php');
}

@ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
$db->query("set names utf8");
$count = "select count(*) from followerlist where user_id = '$user_id'";
$follower_count = $db->query($count);
$count_result = $follower_count->fetch_row();
if ($count_result[0] > 199) {
  $_SESSION['addfollowers'] = "<div id='addfollowers-response' class='text orange'>fail whale... can't have more than 200 followers listed</div>";
  header('Location: index.php');
  exit;
}

$friend = $connection->get('users/show', array('screen_name' => $addfollower));   
$follower_id = $friend->id;
$follower_pic = $friend->profile_image_url;
$email = "select email from users where user_id = '$user_id'";
$email_result = $db->query($email);
$email_check = $email_result->fetch_array();
if ($email_check[0]) {
  $followerlist = "insert into followerlist (user_id, followers) values ('$user_id', '$follower_id')";
  $db->query($followerlist);
  $guid = $_COOKIE['userid'];
  $cookies = "update cookies set GUID = '$guid' where user_id = '$user_id'";
  $db->query($cookies);

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
}
else {
  $_SESSION['addfollower'] = $addfollower;
  $_SESSION['follower_id'] = $follower_id;
  $_SESSION['follower_pic'] = $follower_pic;
  include('email.inc');
}

?>
<?php

session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$addfollower = $_POST['addemail'];
$user_follower = $connection->get('users/show', array('screen_name' => $addfollower));

$_SESSION['addfollower'] = $addfollower;
$_SESSION['follower_id'] = $user_follower->id;
$_SESSION['follower_pic'] = $user_follower->profile_image_url;

?>
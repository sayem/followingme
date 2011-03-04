<?php

require_once('/twitteroauth/twitteroauth.php');
require_once('/config.php');

@ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
$db->query("set names utf8");
$twitterusers = "select * from users";
$user_result = $db->query($twitterusers);
$key = 'XXXX';

while ($user = $user_result->fetch_array()) {
  $user_id = $user['user_id'];
  $screen_name = $user['screen_name'];
  $email = $user['email'];

  $oauth = "select aes_decrypt(oauth_token, '$key'), aes_decrypt(oauth_token_secret, '$key') from users where user_id = '$user_id'";
  $oauth_query = $db->query($oauth);
  $oauths = $oauth_query->fetch_array();
  $oauth_token = $oauths[0];
  $oauth_token_secret = $oauths[1];

  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
  $check = $connection->get('users/show', array('user_id' => $user_id));
  $check_name = $check->screen_name;
  if ($screen_name != $check_name) {
    $update_name = "update users set screen_name = '$check_name' where user_id = '$user_id'";
    $db->query($update_name);
  }
  $follower_list = "select followers from followerlist where user_id = '$user_id'";
  $follower_result = $db->query($follower_list);

  while ($followerlist = $follower_result->fetch_array()) {
    $followers = $followerlist['followers'];  
    $friendship= $connection->get('friendships/show', array('target_id' => $followers));
    $follower_screen_name = $friendship->relationship->target->screen_name;
    $friendcheck = $friendship->relationship->target->following;
    if ($friendcheck != 1) {
      $unfollowed = $connection->get('users/show', array('screen_name' => $follower_screen_name));
      $follower_name = $unfollowed->name;
      $follower_pic = $unfollowed->profile_image_url;
      $follower_date = date('l, M dS');
      include('cron-email.php');
      $mail = "insert into mail (user_id, subject, sent) values ('$user_id', '$subject', curdate())";
      $sent_mail = $db->query($mail);
      $remove = "delete from followerlist where user_id = '$user_id' and followers = '$followers'";
      $delete_follower = $db->query($remove);
    }
  }
}

$user_result->free(); 
$db->close(); 

?>
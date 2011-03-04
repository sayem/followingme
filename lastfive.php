<?php

session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
$access_token = $_SESSION['access_token'];
$user_id = $access_token['user_id'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

class Last_Five {
  private $name; private $pic;
  function setname($value) {
    $this->name = $value;
  }
  function setpic($value) {
    $this->pic = $value;
  }
  function getname() {
    return $this->name;
  }  
  function getpic() {
    return $this->pic;
  }
}
$user_lastfive = 'last-five_' . $user_id;
if (apc_exists($user_lastfive)) {
  $last_five = apc_fetch($user_lastfive);
}
else {
  $followers = $connection->get('followers/ids');
  $lastfive_names = array();
  $lastfive_pics = array();
  for ($i = 0; $i < 5; $i++) {
    $user = $connection->get('users/show', array('user_id' => $followers[$i]));
    $follower_name[$i] = $user->screen_name;
    $follower_picture[$i] = $user->profile_image_url;
    array_push($lastfive_names, $follower_name[$i]);
    array_push($lastfive_pics, $follower_picture[$i]);
  }
  $last_five = new Last_Five;
  $last_five->setname($lastfive_names);
  $last_five->setpic($lastfive_pics);
  apc_add($user_lastfive, $last_five, 900);
}
$names = $last_five->getname();
$pics = $last_five->getpic();

for ($i=0; $i<5; $i++) {
  print
"<li class='fm-list five'>
<img src='$pics[$i]'/>
<div class='fm-names add'>$names[$i]</div>
</li>";
}

?>
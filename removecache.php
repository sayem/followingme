<?php

session_start();
$user_id = $_SESSION['user_id'];
$remove = $_POST['remove'];
$user_addfollowingme = 'add_followingme_' . $user_id;

$addfollowingme = apc_fetch($user_addfollowingme);
$followers_names = $addfollowingme[0];
$followers_pics = $addfollowingme[1];

$key = array_search($remove, $followers_names);
unset($followers_names[$key]);
unset($followers_pics[$key]);
$addfollowingme = array($followers_names, $followers_pics);
apc_store($user_addfollowingme, $addfollowingme, 900);

?>
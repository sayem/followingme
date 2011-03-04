<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <title>Followingme.net - Find out whenever someone you know stops following you on Twitter</title>
   <meta name="description" content="Twitter app that alerts you whenever someone you know stops following you." />
   <link rel="shortcut icon" href="static/v1/images/favicon.ico" type="image/vnd.microsoft.icon" />
   <link rel="stylesheet" href="static/v1/css/blueprint/screen.css" type="text/css" media="screen" />
   <!--[if lt IE 8]><link rel="stylesheet" href="static/v1/css/blueprint/ie.css" type="text/css" media="screen"><![endif]-->
   <link rel="stylesheet" type="text/css" href="static/v1/css/main.css" />
   <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/overcast/jquery-ui.css" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
   <script src="static/v1/js/jquery.hint.js" type="text/javascript"></script>
</head>
 <body>
<div class="container" id="page">
<div id="header">
    <a href="/"><img id="title" src="static/v1/images/followingme.png" /></a>
    <div id="blurb-header">
      <div class="text blurb">
You've got a ton of followers on Twitter. But just a handful of them are important to you <br />
Find out whenever any of them happen to stop following you <br />
by using <span style="border-bottom: 3px solid #ff6600">Followingme</span>
      </div>
      <div id="logout"><a href="logout.php"><img src="static/v1/images/logout.png" alt="log out"/></a></div>
    </div>
</div>
<div id="center-container">
  <div id="welcome">
   <div id="profile">
<?php
   session_start();
   $user_id = $_SESSION['user_id'];
   $screen_name = $_SESSION['screen_name'];
   $picture = $_SESSION['picture'];
?>
   <div id="profile-user"><?php print $screen_name?></div>
   <img src="<?php print $picture?>"></img> 
   </div>
<div id="options"><a href='options.php'>Options</a></div>
</div>
<div id="change-email" class="text">
<?php
  @ $db = new mysqli('localhost', 'XXXX', 'XXXX', 'XXXX');
  $db->query("set names utf8");
  $email_address = "select email from users where user_id = '$user_id'";
  $email_result = $db->query($email_address);
  $email_add = $email_result->fetch_array();
  $email = $email_add[0];
?>
<div id="email-address">Your email address: <span style="color: #0066cc; font-size: 0.9em;"><?php print $email?></span></div>
<form id="form-change-email" method="post" name="change-email" action="update.php">
  <input type='text' name='change-email' title='change your email address'>
  <input type='submit' value='submit'>
</form>
<?php print $_SESSION['update']?>
</div>
<div id="delete" class="text">
  Delete your account - <br />
  <span style="font-size: 0.7em">(clicking this button will delete your follower list and email address)</span>
  <div id="delete-button"><a href="delete.php">Remove Account</a></div>
</div>
</div>
   <div id="footer" style="padding-bottom: 50px">
   <img id="twitter" src="static/v1/images/twitter.png" alt="@followingme_net"/><a href="http://twitter.com/followingme_net" target="_blank">follow us on twitter</a>
     <span style="font-size: 0.9em; color: #9F9F9F;"> - &copy 2011 - </span>
     <a href="mailto:contact@followingme.net">contact@followingme.net</a>
     <br /><br />Wonder whether someone removed you as a friend on Facebook?<br />Check out:  <a href="http://friendsnomore.net" target="_blank">Friends No More</a>
   </div>
</div>
 </body>
<script src="static/v1/js/followingme.js" type="text/javascript"></script>
</html>
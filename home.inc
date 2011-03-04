<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <title>Followingme.net - Find out whenever someone you know stops following you on Twitter</title>
   <meta name="description" content="Twitter app that alerts you whenever someone you know stops following you." />
   <link rel="shortcut icon" href="static/v1/images/favicon.ico" type="image/vnd.microsoft.icon" />
   <link rel="stylesheet" href="static/v1/css/blueprint/screen.css" type="text/css" media="screen" />
   <link rel="stylesheet" type="text/css" href="static/v1/css/main.css" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
   <script src="static/v1/js/jquery.hint.js" type="text/javascript"></script>
</head>
 <body>
<div class="container" id="homepage">
   <div id="header">
    <a href="/"><img id="title" src="static/v1/images/followingme.png" /></a>
    <div id="blurb-header">
      <div id="blurb-text" class="text blurb">
You've got a ton of followers on Twitter. But just a handful of them are important to you <br />
Find out whenever any of them happen to stop following you <br />
by using <span style="border-bottom: 3px solid #ff6600">Followingme</span>
      </div>
      <div id="login"><a href="redirect.php"><img src="static/v1/images/lighter.png" alt="Sign in with Twitter"/></a></div>
    </div>
   </div>
<div id="center-container">
   <div id="addfollowers">
     <img id="bubble_how-to" src="static/v1/images/bubble.png">
   <div class="text how-to">
1 - Sign in with your Twitter account <br />
2 - Create a list of followers that you want us to keep track of <br />
3 - Enter your email address and then you're all set <br />
   </div>
   <form id="form-followers" method="get" name="addfollowersform" action="addfollowers.php" >
     <input id='addfollower' type='text' title='one of your followers' name='addfollower' />
     <input type="submit" value="add follower">
   </form>
   <div class="text alert-you">
We'll email you whenever anyone on your list unfollows you
   </div>
   </div>
   <div id="does-follow">
     <div class="text check-followers">
Wonder whether two people are following each other? <br /> 
Check by entering their usernames below
     </div>   
     <div id="friendship" class="text">
       <form id="form-friendship" method="post" name="followform" action="friendship.php" >
	 Is <input type='text' title='twitter username' name='1' id='1' /> following <input type='text' title='twitter username' name='2' id='2' /> ? <input type="submit" value="check">
       </form>
       <?php print $friendship;?>
     </div>
   </div>
</div>
   <div id="footer">
 <img id="twitter" src="static/v1/images/twitter.png" alt="@followingme_net"/><a href="http://twitter.com/followingme_net" target="_blank">follow us on twitter</a>
     <span style="font-size: 0.9em; color: #9F9F9F;"> - &copy 2011 - </span>
     <a href="mailto:contact@followingme.net">contact@followingme.net</a>
     <br /><br />Wonder whether someone removed you as a friend on Facebook?<br />Check out:  <a href="http://friendsnomore.net" target="_blank">Friends No More</a>
   </div>
</div>
</body>
<script src="static/v1/js/followingme.js" type="text/javascript"></script>
</html>
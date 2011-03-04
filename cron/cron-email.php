<?php

require('Mail.php');
require('Mail/mime.php');

$text = <<<_TXT_
$follower_name (http://twitter.com/{$follower_screen_name}) stopped following you on $follower_date.

Keep your Followingme list updated at http://followingme.net.

- Followingme
_TXT_;

$html = <<<_HTML_
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 </head>
<body style="background-color: #ddeef6; height: 400px;">
<table style="width: 700px; height: 275px; margin-left: 50px; margin-top: 40px; color: #4d4a4d; background-color:#ffffff; font-size: 1.05em; font-family: arial, helvetica, sans-serif; font-weight: bold;">
  <table style="margin-left: 40px; margin-top: 25px; width: 600px; padding-bottom: 35px; line-height: 1.65em;">
<p style="font-size: 1.2em; line-height: 1.7em;"><img src="$follower_pic" style="padding-right: 10px;"/>$follower_name <span style="font-size: 1.05em; font-weight: normal;">(<a href="http://twitter.com/{$follower_screen_name}">http://twitter.com/{$follower_screen_name}</a>)</span> stopped following you on<br /><span style="padding-left: 10px">$follower_date.</span></p>
<p style="padding-left: 10px">Keep your Followingme list updated at <a href="http://followingme.net">http://followingme.net</a>.</p>
<p>- <span style="color: #0066cc">Followingme</span></p>
  </table>
</table>
</body>
</html>
_HTML_;

$subject = "$follower_name just unfollowed you on Twitter";
$headers = array('From' => 'Followingme.net <admin@followingme.net>', 'Subject' => $subject);
$mime = new Mail_mime();
$mime->setTXTBody($text);
$mime->setHTMLBody($html);
$msg_body = $mime->get();
$msg_headers = $mime->headers($headers);
$mail =& Mail::factory('mail', array('Return-Path' => '-f admin@followingme.net'));
$mail->send($email, $msg_headers, $msg_body);

?>
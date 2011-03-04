<?php

require('Mail.php');
require('Mail/mime.php');

$text = <<<_TXT_
Thanks for signing up for Followingme!

You'll get an email from us whenever anyone on your list stops following you on Twitter. Be sure to update your list by going to http://followingme.net to add new followers you want us to keep track of.

Also, check out our app to find out whenever someone removes you as a friend 
on Facebook: Friends No More (http://friendsnomore.net)

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
<p>Thanks for signing up for Followingme!</p>
<p>You'll get an email from us whenever anyone on your list stops following you on Twitter. Be sure to update your list by going to <a href='http://followingme.net'>http://followingme.net</a> to add new followers you want us to keep track of.</p>
<p>Also, check out our app to find out whenever someone removes you as a friend<br /> on Facebook: <a href='http://friendsnomore.net'>Friends No More</a></p>
<p>- <span style="color: #0066cc">Followingme</span></p>
  </table>
</table>
</body>
</html>
_HTML_;

$subject = 'Welcome to Followingme, @' . $screen_name;
$headers = array('From' => 'Followingme.net <admin@followingme.net>', 'Subject' => $subject);
$mime = new Mail_mime();
$mime->setTXTBody($text);
$mime->setHTMLBody($html);
$msg_body = $mime->get();
$msg_headers = $mime->headers($headers);
$mail =& Mail::factory('mail', array('Return-Path' => '-f admin@followingme.net'));
$mail->send($email_address, $msg_headers, $msg_body);

?>
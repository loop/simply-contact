<?php

/** start sessions **/
@session_start();

/** include config **/
include('config.php');

/** include functions email **/
include('functions_email.php');

/** reset error & success vars **/
$error = 0;
$success = 0;
$error_message = '';

/** set error message array **/
$error_message = array();

/** try to send message **/
if(isset($_POST['submit']))
{
   /** check if name is filled in **/
   if($_POST['name'] == '')
   {
      $error = 1;
      $error_message[] = 'Please fill in your full name.';
   }
   
   /** check if email is filled in **/
   if($_POST['email'] == '')
   {
      $error = 1;
      $error_message[] = 'Please enter a valid email.';
   }
   
   /** check if subject is filled in **/
   if($_POST['subject'] == '')
   {
      $error = 1;
      $error_message[] = 'Please enter a subject.';
   }
   
   /** check if comment is filled in **/
   if($_POST['comments'] == '')
   {
      $error = 1;
      $error_message[] = 'Please write a comment.';
   }

   /** check if captcha is correct **/
   if($_POST['Captcha'] != $_SESSION['Captcha'] || $_POST['Captcha'] == '')
   {
      $error = 1;
      $error_message[] = 'Please choose the correct captcha.';
   }

   /** no error **/
   if($error != 1)
   {
      send_generic($mailto, $_POST['email'], $_POST['subject'], $_POST['comments']);
	  if($autorespond == true){ send_generic($_POST['email'], $mailto, 'RE: '.$_POST['subject'], $autorespond_message); }
      $success = 1;
   }
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
#contact {background: #fff; border: 1px solid #e7e7e7; margin: 30px auto 1em; text-align: left; width: 400px; padding: 2em; margin-bottom: 30px;}
#contact #error {background: #f9efef url(images/cross.png) no-repeat 9px 8px; width: auto; height: auto; padding: 9px 34px; color: #494949; font: 11px arial; border: 1px #e9c6c6 solid; margin-bottom: 20px;}
#contact #success {background: #DFF2BF url(images/tick.png) no-repeat 9px 8px; width: auto; height: 13px; padding: 9px 34px; color: #4F8A10; font: 11px arial; border: 1px #4F8A10 solid;}
#contact .clearfix:after {content: "."; display: block; height: 0; clear: both; visibility: hidden;}
#contact hr {border: 0px; background: none; border-bottom: 1px dotted #aaa; height: 0px; margin: 1em 0;}
#contact label {display: block; margin-bottom: 4px; color: #6182a1;}
#contact input[type=text], #contact input[type=password], #contact textarea {color: #333; margin-bottom: 7px; background: #fff; border: 1px solid #ccc; padding: 5px; width: 95%;}
#contact input[type=submit] {background: #eee; border: 3px double #ccc; padding: 2px; font-size: 1em; width: auto; margin-right: 6px;}
#contact a {color: #6182a1; font: inherit; text-decoration: none;}
#contact #captcha div {display: inline; float: left;} 
</style>
<script type="text/javascript" src="./javascript/jquery.js"></script>
<script type="text/javascript" src="./javascript/captcha.js"></script>
<title>Simply Contact</title>
</head>
<body>
<div id="contact" class="clearfix">
  <?php 
  if($error == 1)
  {
     echo '<div id="error">';
     foreach($error_message as $err){ echo $err . "<br>"; }
	 echo '</div>';
  }
  ?>
  
  <?php if($success != 1): ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="name">Name</label>
    <input name="name" id="name" size="30" type="text" value="<?php echo $_POST['name']; ?>" />
    <label for="email">Email</label>
    <input name="email" id="email" size="30" type="text" value="<?php echo $_POST['email']; ?>" />
    <label for="subject">Subject</label>
    <input name="subject" id="subject" size="30" type="text" value="<?php echo $_POST['subject']; ?>" />
    <label for="comments">Comments</label>
    <textarea name="comments" cols="46" rows="5" id="comments"><?php echo $_POST['comments']; ?></textarea>
    <div id="captcha"><?php require('captcha.php'); ?></div><br /><br />
    <hr>
    <input name="submit" value="Submit" type="submit" />
  </form>
  <?php else: ?>
  <div id="success">Thank you for your comments.</div>  
  <?php endif; ?>
</div>
</body>
</html>
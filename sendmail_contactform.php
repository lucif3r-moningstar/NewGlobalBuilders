<?php
require 'phpm/PHPMailerAutoload.php'; 
if(isset($_POST['Email'])) {
  // EDIT THE 2 LINES BELOW AS REQUIRED
  $email_to1 = "zafarbabukhan@gmail.com";
  $email_to2 = "zafarbabukhan@hotmail.com";
  $email_subject = "Request from NewGlobalBuilders.COM: ";

  $mail = new PHPMailer;
  //$mail->SMTPDebug = 3;       // Enable verbose debug output
  $mail->isSMTP();                    // Set mailer to use SMTP
  $mail->Host = 'mail.bhagavatihomoeo.com';
  $mail->SMTPAuth = true;                               
  $mail->Username = 'webform@bhagavatihomoeo.com';   
  $mail->Password = 'Bhagavati17#';
  $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted with port 465
  $mail->Port = 587;  
  
  function died($error) {
    // your error code can go here
    echo "We are very sorry, but there were error(s) found with the form you submitted. ";
    echo "These errors appear below.<br /><br />";
    echo $error."<br /><br />";
    echo "Please go back and fix these errors.<br /><br />";
    die();
  }
 
    // validation expected data exists
    if(!isset($_POST['Name']) ||
       !isset($_POST['Subject']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Mobile']) ||
        !isset($_POST['text'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
    $Name = $_POST['Name'];                     // required
   $Subject = $_POST['Subject'];                // required
    $email_from = $_POST['Email'];              // required
    $Mobile = $_POST['Mobile'];                   // not required
    $text = $_POST['text'];                           // required
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
  $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$Name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
  }
  if(strlen($text) < 2) {
    $error_message .= 'The Complaints you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
  $email_message = "";
  function clean_string($string) {
       $bad = array("content-type","bcc:","to:","cc:","href");
       return str_replace($bad,"",$string);
  }
  $email_message .= "Name: ".clean_string($Name)."\n\n";   
  $email_message .= "Email: ".clean_string($email_from)."\n\n";
  $email_message .= "Mobile No.: ".clean_string($Mobile)."\n\n";
  $email_message .= "Subject: ".clean_string($Subject)."\n\n";
  $email_message .= "Details: ".clean_string($text)."\n\n";
 
  $mail->setFrom(/*'webform@bhagavatihomoeo.com'*/, 'Bhagavati Homoeo Contact Form');
  $mail->addAddress($email_to1);
  $mail->addBCC($email_to2);  
  $mail->addReplyTo($email_from); 
  $mail->isHTML(false);  
  $mail->Subject = $email_subject;
  $mail->Body    = $email_message;
  
  if(!$mail->send()) {
    echo $error_message;
    echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
    echo 'Thank you for contacting us. We will be in touch with you very soon.';
  }
}
?>
<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require_once 'PHPMailer-master/PHPMailer-master/src/Exception.php';
  require_once 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
  require_once 'PHPMailer-master/PHPMailer-master/src/SMTP.php';
  require_once 'user_php/config.php';
  require_once 'admin_php/connect.php';

function send_mail($recipient,$subject,$message)
{

  $mail = new PHPMailer();
  $mail->IsSMTP();

  $mail->SMTPDebug  = 0;  
  $mail->SMTPAuth   = TRUE;
  $mail->SMTPSecure = "ssl";
  $mail->Port       = 465;
  $mail->Host       = "smtp.gmail.com";
  //$mail->Host       = "smtp.mail.yahoo.com";
  $mail->Username   = "achmadtirtosudirosudiro@gmail.com";
  $mail->Password   = "tfncelztnhuvuwvy";

  $mail->IsHTML(true);
  $mail->AddAddress($recipient, "esteemed customer");
  $mail->SetFrom("achmadtirtosudirosudiro@gmail.com", "Achmad Tirto Sudiro");
  //$mail->AddReplyTo("reply-to-email", "reply-to-name");
  //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
  $mail->Subject = $subject;
  $content = $message;

  $mail->MsgHTML($content); 
  if(!$mail->Send()) {
    //echo "Error while sending Email.";
    //echo "<pre>";
    //var_dump($mail);
    return false;
  } else {
    //echo "Email sent successfully";
    return true;
  }

}

?>

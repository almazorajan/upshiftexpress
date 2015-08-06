<?php 

//sendPHPMail('clairealfon@yahoo.com', 'test', 'test');
sendPHPMail('almazorajan@gmail.com', 'test', 'test');

function sendPHPMail($recipient, $mailSubject, $mailContent) {

  require_once 'phpmailer/PHPMailerAutoload.php';
  require_once 'phpmailer/class.phpmailer.php';
  require_once 'phpmailer/class.smtp.php';
  require_once 'template.php';

  /* CONFIGURATION */
  // $crendentials = array(
  //     'email'     => 'support@upshift.com.ph'
  //     , 'password'  => 'shiftupsupport.8'
  // );

  // $smtp = array(
  //   'host'     => 'smtp.office365.com'
  //   , 'port'     => 587
  //   , 'username' => $crendentials['email']
  //   , 'password' => $crendentials['password']
  //   , 'secure'   => 'tls'
  // );

  $crendentials = array(
    'email'       => 'almazorajan@gmail.com'
    , 'password'  => 'Chemicalhard2015'
  );

  $smtp = array(
    'host'        => 'smtp.gmail.com'
    , 'port'      => 465
    , 'username'  => $crendentials['email']
    , 'password'  => $crendentials['password']
    , 'secure'    => 'ssl'
  );

  $to         = $recipient;
  $subject    = $mailSubject;
  $content    = $mailContent;

  $mailer = new PHPMailer();

  $mailer->isSMTP();
  $mailer->SMTPAuth   = true; 
  $mailer->Host       = $smtp['host'];
  $mailer->Port       = $smtp['port'];
  $mailer->Username   = $smtp['username'];
  $mailer->Password   = $smtp['password'];
  $mailer->SMTPSecure = $smtp['secure']; 

  $mailer->From       = $crendentials['email'];
  $mailer->FromName   = 'Upshift Express Inc.'; 
  $mailer->addAddress($to);  
  
  $mailer->Subject        = $subject;
  $mailer->Body           = $template;
  $mailer->isHTML(true); 

  if(!$mailer->send()) {
    //echo 'Error sending mail : ' . $mailer->ErrorInfo;
    return false;
  } else {
    //echo 'Message sent !';
    return true;
  }
}

?>
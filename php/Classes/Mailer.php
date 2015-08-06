<?php 

class Mailer
{
	private $email;

	private $credentials;
	private $smtp;
	private $recepient;
	private $mailer;

	private $template;

	public Mailer()
	{
		$this->credentials 				= array();
		$this->credentials['email'] 	= 'almazorajan@gmail.com';
		$this->credentials['password'] 	= 'Chemicalhard2015';

		$this->smtp 			= array();
		$this->smtp['host'] 	= 'smtp.gmail.com';
		$this->smtp['port'] 	= 465;
		$this->smtp['username'] = $this->credentials['email'];
		$this->smtp['password'] = $this->credentials['password'];
		$this->smtp['secure'] 	= 'ssl';

		$this->mailer 				= new PHPMailer();
		$this->mailer->isSMTP();
		$this->mailer->SMTPAuth   	= true; 
		$this->mailer->Host       	= $this->smtp['host'];
		$this->mailer->Port       	= $this->smtp['port'];
		$this->mailer->Username   	= $this->smtp['username'];
		$this->mailer->Password   	= $this->smtp['password'];
		$this->mailer->SMTPSecure 	= $this->smtp['secure'];

		$this->mailer->From 		= $this->credentials['email'];
		$this->mailer->FromName 	= 'Upshift Express Inc.'; 
		$mailer->isHTML(true); 

		$this->template 			= new MailerTemplate();
	}

	private function SendMail()
	{
		$mailer->Body = $template;

		if( $this->mailer->send() )
			return true;
		else
			return false;
	}

	public function SetRecepient( $value )
	{
		$this->mailer->addAddress( $value );
		$this->recepient = $value;
	}

	public function EmailNewMember()
	{
		//todo
	}

	public function EmailNewPassword( $newPassword )
	{
		$mailer->Subject = 'Password Recovery';
		$this->template->SetCurrentEmail( $this->recepient );
		$this->template->SetCurrentPassword( $newPassword );
  		$template = $template->GetNewPasswordTemplate();
	}

	public function EmailBookingDetails()
	{
		//todo
	}
}




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

  // $crendentials = array(
  //   'email'       => 'almazorajan@gmail.com'
  //   , 'password'  => 'Chemicalhard2015'
  // );

  // $smtp = array(
  //   'host'        => 'smtp.gmail.com'
  //   , 'port'      => 465
  //   , 'username'  => $crendentials['email']
  //   , 'password'  => $crendentials['password']
  //   , 'secure'    => 'ssl'
  // );

  // $to         = $recipient;
  // $subject    = $mailSubject;
  // $content    = $mailContent;

  // $mailer = new PHPMailer();

  // $mailer->isSMTP();
  // $mailer->SMTPAuth   = true; 
  // $mailer->Host       = $smtp['host'];
  // $mailer->Port       = $smtp['port'];
  // $mailer->Username   = $smtp['username'];
  // $mailer->Password   = $smtp['password'];
  // $mailer->SMTPSecure = $smtp['secure']; 

  // $mailer->From       = $crendentials['email'];
  // $mailer->FromName   = 'Upshift Express Inc.'; 
  // $mailer->addAddress($to);  
  
  // $mailer->Subject        = $subject;
  // $mailer->Body           = $template;
  // $mailer->isHTML(true); 

  // if(!$mailer->send()) {
  //   //echo 'Error sending mail : ' . $mailer->ErrorInfo;
  //   return false;
  // } else {
  //   //echo 'Message sent !';
  //   return true;
  // }

?>
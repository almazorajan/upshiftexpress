<?php 

	include_once('../../../php/Classes/Connector.php');

	// include_once('../../../php/Classes/MailerTemplate.php');
	// include_once('../../../php/Classes/Mailer.php');

	// include_once('../../../php/Mailer/phpmailer/PHPMailerAutoload.php');
	// include_once('../../../php/Mailer/phpmailer/class.phpmailer.php');
	// include_once('../../../php/Mailer/phpmailer/class.smtp.php');

	class User
	{
		public $email;
		public $firstName;
		public $middleName;
		public $lastName;
		public $address;
		public $contactNo;
		public $houseNo;
		public $companyName;
		public $barangay;
		public $city;
		public $district;
	}

	class PasswordGenerator
	{
		private $currentEmail;

		public function SetCurrentEmail( $value )
		{
			$this->currentEmail = $value;
		}

		private function GeneratePassword( $length = 9, $add_dashes = false, $available_sets = 'luds' )
		{
			$sets = array();
			if(strpos($available_sets, 'l') !== false)
				$sets[] = 'abcdefghjkmnpqrstuvwxyz';
			if(strpos($available_sets, 'u') !== false)
				$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
			if(strpos($available_sets, 'd') !== false)
				$sets[] = '23456789';
			if(strpos($available_sets, 's') !== false)
				$sets[] = '!@#$%&*?';
		 
			$all = '';
			$password = '';
			foreach($sets as $set)
			{
				$password .= $set[array_rand(str_split($set))];
				$all .= $set;
			}
		 
			$all = str_split($all);
			for($i = 0; $i < $length - count($sets); $i++)
				$password .= $all[array_rand($all)];
		 
			$password = str_shuffle($password);
		 
			if(!$add_dashes)
				return $password;
		 
			$dash_len = floor(sqrt($length));
			$dash_str = '';
			while(strlen($password) > $dash_len)
			{
				$dash_str .= substr($password, 0, $dash_len) . '-';
				$password = substr($password, $dash_len);
			}
			$dash_str .= $password;
			return $dash_str;
		}

		public function GenerateNewPassword()
		{
			$connector 			= new Connector();
			$newPassword 		= $this->GeneratePassword();

			$sql 	= "";
			$sql 	.= " UPDATE members_info";
			$sql 	.= "	SET password = '" . md5( $newPassword ) . "'";
			$sql 	.= " WHERE";
			$sql 	.= " 	email = '" . $this->currentEmail . "'";

			$mysqliQuery = mysqli_query( $connector->GetConnection(), $sql );

			if( $mysqliQuery ) 
			{
				$mailer = new Mailer();

				$mailer->SetRecepient( $this->currentEmail );
				$mailer->EmailNewPassword( $newPassword );
				$mailer->SendMail();
				return true;
			}
			else
				return false;
		}
	}
?>

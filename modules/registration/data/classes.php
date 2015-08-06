<?php

	include_once('../../../php/Classes/Connector.php');

	class SecurityQuestion
	{
		public $question;
		public $answer;
	}

	class Member
	{
		private $firstName;
		private $middleName;
		private $lastName;
		private $email;
		private $password;
		private $status;
		private $contactNo;

		private $houseNo;
		private $companyName;
		private $barangay;
		private $city;
		private $district;
		private $securityQuestion;

		public function __construct()
		{
			$this->securityQuestion = new SecurityQuestion();
		}

		public function SetFirstName( $value )
		{	
			$this->firstName = $value;
		}

		public function SetMiddleName( $value )
		{
			$this->middleName = $value;
		}

		public function SetLastName( $value )
		{
			$this->lastName = $value;
		}

		public function SetEmail( $value )
		{
			$this->email = $value;
		}

		public function SetPassword( $value )
		{
			$this->password = $value;
		}

		public function SetStatus( $value )
		{
			$this->status = $value;
		}

		public function SetContactNo( $value )
		{
			$this->contactNo = $value;
		}

		public function SetHouseNo( $value )
		{
			$this->houseNo = $value;
		}

		public function SetCompanyName( $value )
		{
			$this->companyName = $value;
		}

		public function SetBarangay( $value )
		{
			$this->barangay = $value;
		}

		public function SetCity( $value )
		{
			$this->city = $value;
		}

		public function SetDistrict ( $value )
		{
			$this->district = $value;
		}

		public function Add() 
		{
			$connector 	= new Connector();
			$sqlInfo 	= "";
			$sqlAddress = "";

			$sqlInfo .= " INSERT INTO members_info";
			$sqlInfo .= " VALUES";
			$sqlInfo .=	" (";
			$sqlInfo .= " '"	. $this->email 			. "'";
			$sqlInfo .= " , '"	. md5($this->password) 	. "'";
			$sqlInfo .= " , '"	. $this->lastName 		. "'";
			$sqlInfo .= " , '"	. $this->firstName 		. "'";
			$sqlInfo .= " , '"	. $this->middleName 	. "'";
			$sqlInfo .= " , '"	. $this->contactNo 		. "'";
			$sqlInfo .= " , "	. $this->status;
			$sqlInfo .= " );";

			$sqlAddress .= " INSERT INTO members_address";
			$sqlAddress .= " VALUES";
			$sqlAddress .= " (";
			$sqlAddress .= " '" 	. $this->email 			. "'";
			$sqlAddress .= " , '" 	. $this->houseNo 		. "'";
			$sqlAddress .= " , '" 	. $this->companyName 	. "'";
			$sqlAddress .= " , '" 	. $this->barangay 		. "'";
			$sqlAddress .= " , '" 	. $this->city 			. "'";
			$sqlAddress .= " , '" 	. $this->district 		. "'";
			$sqlAddress .= " , ( SELECT regionname FROM cities WHERE cityname = '" . $this->city . "' )";
			$sqlAddress .= " , " 	. $this->status;
			$sqlAddress .= " );";
	
			$mysqliQueryInfo 	= mysqli_query( $connector->GetConnection(), $sqlInfo );
			$mysqliQueryAddress = mysqli_query( $connector->GetConnection(), $sqlAddress );	
			
			if( $mysqliQueryInfo && $mysqliQueryAddress )
				return 'true';
			else
				return mysqli_error($connector->GetConnection());
		}
	}

	class EmailChecker
	{
		public function ValidateEmail( $value ) 
		{
			$connector 	= new Connector();
			$sql 		= "";
			
			$sql .= " SELECT COUNT( email ) AS Counter FROM members_info";
			$sql .= " WHERE email='" . $value . "'";

			$mysqliQuery = mysqli_query( $connector->GetConnection(), $sql );

			if( $mysqliQuery ) {

				if ( mysqli_fetch_array( $mysqliQuery )['Counter'] == 0 )				
					return false;	
				else
					return true;
			}

			return false;
		}
	}
?>
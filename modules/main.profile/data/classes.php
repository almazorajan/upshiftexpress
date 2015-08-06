<?php 

	include_once('../../../php/Classes/Connector.php');

	class CustomerEmailUpdater
	{
		private $currentEmail;
		private $newEmail;
		private $currentPassword;

		public function SetCurrentEmail( $value )
		{
			$this->currentEmail = $value;
		}

		public function SetNewEmail( $value )
		{
			$this->newEmail = $value;
		}

		public function SetCurrentPassword( $value )
		{
			$this->currentPassword = $value;
		}

		public function UpdateEmail()
		{
			$connector = new Connector();

			$sql = "";

			$sql .= " SELECT COUNT( email ) AS Counter FROM members_info";
			$sql .= " WHERE";
			$sql .= " 	email = '" . $this->currentEmail . "'";
			$sql .= "	AND password = '" . md5( $this->currentPassword ) . "'";

			$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

			$counter = mysqli_fetch_array($mysqliQuery)["Counter"];

			if( $counter == '1' )
			{
				$sql = "";
				$sql .= " UPDATE members_info";
				$sql .= " SET email = '" . $this->newEmail . "'";
				$sql .= " WHERE";
				$sql .= " 	email = '" . $this->currentEmail . "'";
				$sql .= "	AND password = '" . md5( $this->currentPassword ) . "'";

				$sql2 = "";
				$sql2 .= " UPDATE members_address";
				$sql2 .= " SET email = '" . $this->newEmail . "'";
				$sql2 .= " WHERE";
				$sql2 .= " 	email = '" . $this->currentEmail . "'";

				$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);
				$mysqliQuery2 = mysqli_query($connector->GetConnection(), $sql2);

				if( $mysqliQuery && $mysqliQuery2 )
					return true;
				else
					return false;
			}
			else
			{
				return false;
			}
		}
	}

	class CustomerPasswordUpdater
	{
		private $currentEmail;
		private $currentPassword;
		private $newPassword;
		private $confirmNewPassword;

		public function SetCurrentEmail( $value )
		{
			$this->currentEmail = $value;
		}

		public function SetCurrentPassword( $value )
		{
			$this->currentPassword = $value;
		}

		public function SetNewPassword( $value )
		{
			$this->newPassword = $value;
		}

		public function SetConfirmNewPassword( $value )
		{
			$this->confirmNewPassword = $value;
		}

		public function UpdatePassword()
		{
			$connector = new Connector();

			if( $this->newPassword == $this->confirmNewPassword )
			{
				$sql = "";

				$sql .= " SELECT COUNT( email ) AS Counter FROM members_info";
				$sql .= " WHERE";
				$sql .= " 	email = '" . $this->currentEmail . "'";
				$sql .= "	AND password = '" . md5( $this->currentPassword ) . "'";

				$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

				$counter = mysqli_fetch_array( $mysqliQuery )["Counter"];

				if( $counter == '1' )
				{
					$sql = "";
					$sql .= " UPDATE members_info";
					$sql .= " SET password = '" . md5( $this->newPassword ) . "'";
					$sql .= " WHERE";
					$sql .= " 	email = '" . $this->currentEmail . "'";

					$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

					if( $mysqliQuery )
						return true;
					else
						return false;
				}
				else
				{
					return false;
				}
			}
		}
	}

	class CustomerAddressUpdater
	{
		private $currentEmail;
		private $currentPassword;
		private $houseNo;
		private $companyName;
		private $barangay;
		private $city;
		private $district;

		public function SetCurrentEmail( $value )
		{
			$this->currentEmail = $value;
		}

		public function SetCurrentPassword( $value )
		{
			$this->currentPassword = $value;
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

		public function SetDistrict( $value )
		{
			$this->district = $value;
		}

		public function UpdateAddress()
		{
			$connector = new Connector();

			$sql = "";

			$sql .= " SELECT COUNT( email ) AS Counter FROM members_info";
			$sql .= " WHERE";
			$sql .= " 	email = '" . $this->currentEmail . "'";
			$sql .= "	AND password = '" . md5( $this->currentPassword ) . "'";

			$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

			$counter = mysqli_fetch_array( $mysqliQuery )["Counter"];

			if( $counter == '1' )
			{
				$sql = "";
				$sql .= " UPDATE members_address";
				$sql .= " SET";
				$sql .= "	houseno 		= '" . $this->houseNo . "'";
				$sql .= "	, companyname 	= '" . $this->companyName . "'";
				$sql .= "	, barangay 		= '" . $this->barangay . "'";
				$sql .= "	, city 			= '" . $this->city . "'";
				$sql .= "	, district 		= '" . $this->district . "'";
				$sql .= "	, state 		= ( SELECT regionname FROM cities WHERE cityname = '" . $this->city . "' )";
				$sql .= "	, status 		= 1";
				$sql .= " WHERE";
				$sql .= "	email = '" . $this->currentEmail . "'";

				$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

				if( $mysqliQuery )
					return true;
				else
					return false; 
			}
			else
			{
				return false;
			}
		}
	}

	class CustomerContactNoUpdater
	{
		private $currentEmail;
		private $currentPassword;
		private $contactNo;

		public function SetCurrentEmail( $value )
		{
			$this->currentEmail = $value;
		}

		public function SetCurrentPassword( $value )
		{
			$this->currentPassword = $value;
		}

		public function SetContactNo( $value )
		{
			$this->contactNo = $value;
		}

		public function UpdateContactNo()
		{
			$connector = new Connector();

			$sql = "";

			$sql .= " SELECT COUNT( email ) AS Counter FROM members_info";
			$sql .= " WHERE";
			$sql .= " 	email = '" . $this->currentEmail . "'";
			$sql .= "	AND password = '" . md5( $this->currentPassword ) . "'";

			$mysqliQuery 	= mysqli_query($connector->GetConnection(), $sql);
			$counter 		= mysqli_fetch_array( $mysqliQuery )["Counter"];

			if( $counter == '1' )
			{
				$sql = "";
				$sql .= " UPDATE members_info";
				$sql .= " SET";
				$sql .= " 	contactno = '" . $this->contactNo . "'";
				$sql .= " WHERE";
				$sql .= " email = '" . $this->currentEmail . "'";

				$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

				if( $mysqliQuery )
					return true;
				else
					return false;
			}
			else
			{
				return false;
			}
		}
	}

	class CustomerPersonalInfoUpdater
	{
		private $currentEmail;
		private $currentPassword;
		private $firstName;
		private $middleName;
		private $lastName;

		public function SetCurrentEmail( $value )
		{
			$this->currentEmail = $value;
		}

		public function SetCurrentPassword( $value )
		{
			$this->currentPassword = $value;
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

		public function UpdatePersonalInfo()
		{
			$connector = new Connector();

			$sql = "";

			$sql .= " SELECT COUNT( email ) AS Counter FROM members_info";
			$sql .= " WHERE";
			$sql .= " 	email = '" . $this->currentEmail . "'";
			$sql .= "	AND password = '" . md5( $this->currentPassword ) . "'";

			$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

			$counter = mysqli_fetch_array($mysqliQuery)["Counter"];

			if( $counter == '1' )
			{
				$sql = "";
				$sql .= " UPDATE members_info";
				$sql .= " SET";
				$sql .= "	firstname 		= '" . $this->firstName . "'";
				$sql .= "	, middlename 	= '" . $this->middleName . "'";
				$sql .= " 	, lastname 		= '" . $this->lastName . "'";
				$sql .= " WHERE";
				$sql .= "	email = '" . $this->currentEmail . "'";

				$mysqliQuery = mysqli_query($connector->GetConnection(), $sql);

				if( $mysqliQuery )
					return true;
				else
					return false;
			}
			else
			{
				return false;
			}
		}
	}
?>
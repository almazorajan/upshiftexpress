<?php 

	include_once('../../../php/Classes/Connector.php');

	class Customer
	{
		private $email;
		private $name;
		private $houseNo;
		private $companyName;
		private $barangay;
		private $city;
		private $district;
		private $provincialCity;
		private $provincialDistrict;
		private $contactNo;

		public function SetEmail( $value )
		{
			$this->email = $value;
		}

		public function SetName( $value )
		{
			$this->name = $value;
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
			$this->distict = $value;
		}

		public function SetProvincialCity( $value )
		{
			$this->provincialCity = $value;
		}

		public function SetProvincialDistrict( $value )
		{
			$this->provincialDistrict = $value;
		}

		public function SetContactNo( $value )
		{
			$this->contactNo = $value;
		}

		public function GetEmail()
		{
			return $this->email;
		}

		public function GetName() 
		{
			return $this->name;
		}

		public function GetHouseNo()
		{
			return $this->houseNo;
		}

		public function GetCompanyName()
		{
			return $this->companyName;
		}

		public function GetBarangay()
		{
			return $this->barangay;
		}

		public function GetCity()
		{
			return $this->city;
		}

		public function GetDistrict()
		{
			return $this->district;
		}

		public function GetProvincialCity()
		{
			return $this->provincialCity;
		}

		public function GetProvincialDistrict()
		{
			return $this->provincialDistrict;
		}

		public function GetContactNo()
		{
			return $this->contactNo;
		}
	}

	class CollectOnDelivery
	{
		private $bankName;
		private $accountName;
		private $accountNo;
		private $amount;

		public function SetBankName( $value )
		{
			$this->bankName = $value;
		}

		public function SetAccountName( $value )
		{
			$this->accountName = $value;
		}

		public function SetAccountNo( $value )
		{
			$this->accountNo = $value;
		}

		public function SetAmount( $value )
		{
			$this->amount = $value;
		}

		public function GetBankName() 
		{
			return $this->bankName;
		}

		public function GetAccountName() 
		{
			return $this->accountName;
		}

		public function GetAccountNo() 
		{
			return $this->accountNo;
		}

		public function GetAmount() 
		{
			return $this->amount;
		}
	}


	class Book 
	{
		public $sender;
		public $receiver;
		public $cod;
		private $serviceLevel;
		private $size;
		private $height;
		private $length;
		private $width;
		private $weight;
		private $dimension;
		private $chargeableWeight;
		private $declaredValue;
		private $insurance;
		private $suggestion;
		private $paymentMethod;
		private $amountDue;

		public function __construct()
		{
			$this->sender 	= new Customer();
			$this->receiver = new Customer();
			$this->cod 		= new CollectOnDelivery();
		}

		public function SetServiceLevel( $value ) 
		{
			$this->serviceLevel = $value;
		}

		public function SetSize( $value )
		{
			$this->size = $value;
		}

		public function SetHeight( $value )
		{
			$this->height = $value;
		}

		public function SetLength( $value )
		{
			$this->length = $value;
		}

		public function SetWidth( $value )
		{
			$this->width = $value;
		}

		public function SetDimension( $value )
		{
			$this->dimension = $value;
		}

		public function SetWeight( $value )
		{
			$this->weight = $value;
		}

		public function SetChargeableWeight( $value )
		{
			$this->chargeableWeight = $value;
		}

		public function SetInsurance( $value ) 
		{
			$this->insurance = $value;
		}

		public function SetPaymentMethod( $value )
		{
			$this->paymentMethod = $value;
		}

		public function SetSuggestion( $value )
		{
			$this->suggestion = $value;
		}

		public function SetDeclaredValue( $value )
		{
			$this->declaredValue = $value;
		}

		public function SetAmountDue( $value )
		{
			$this->amountDue = $value;
		}

		public function SaveBooking() 
		{
			date_default_timezone_set("Asia/Manila");
			
			$connector 	= new Connector();
			
			$date 		= date('D');
			$hours 		= date('H:i:s');
			$dateToday 	= date('g:m:s A');
			$dateTime 	= date('Y-m-d');

			$randomNumber 	= mt_rand(0, 99999);
			$randomNumber 	= str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
			$day			= date('d');
			$month 			= date('m');
			$referenceNo 	= date('Y').$randomNumber.$month.$day;

			$collectOnDelivery 	= 'NIA';
			$cod 				= 'No';

			$this->serviceLevel = str_replace(" Delivery", "", $this->serviceLevel);
			
			if( $this->serviceLevel == 'Same Day Delivery w/ Collect On Delivery' || $this->serviceLevel == 'Next Day Delivery w/ Collect On Delivery') {
				$collectOnDelivery 	= 'Delivery';
				$cod 				= 'Yes';

				$this->serviceLevel = str_replace(" w/ Collect On Delivery", "", $this->serviceLevel);
			}

			$sql = "";
			$sql .= " INSERT INTO booking_details";
			$sql .= " VALUES";
			$sql .= " (";
			$sql .= " 	 	'" . $referenceNo 			. "'";
			$sql .= " 	 , 	'" . $this->serviceLevel 	. "'";
			$sql .= " 	 , 	'" . $this->size 			. "'";
			$sql .= " 	 , 	'" . $collectOnDelivery 	. "'";
			$sql .= " 	 , 	'" . $cod 					. "'";
			$sql .= " 	 , 	'" . $this->declaredValue 	. "'";
			$sql .= " 	 , 	''";
			$sql .= " 	 , 	" . $this->weight;
			$sql .= " 	 , 	" . $this->height;
			$sql .= " 	 , 	" . $this->length;
			$sql .= " 	 , 	" . $this->width;
			$sql .= " 	 , 	" . $this->amountDue;
			$sql .= " 	 ,  ''"; 	
			$sql .= " 	 ,  ''"; 	
			$sql .= " 	 ,  ''"; 
			$sql .= " 	 ,  ''"; 
			$sql .= " 	 ,  ''"; 	
			$sql .= " 	 ,  ''"; 
			$sql .= " 	 ,  ''";
			$sql .= " 	 ,  '" . $this->sender->GetEmail() 				. "'";
			$sql .= " 	 ,  '" . $this->sender->GetName() 				. "'";	
			$sql .= " 	 ,  '" . $this->receiver->GetName() 			. "'";
			$sql .= " 	 ,  '" . $dateTime . "'";
			$sql .= " 	 ,  '" . $this->receiver->GetHouseNo() 			. "'";
			$sql .= " 	 ,  '" . $this->receiver->GetCompanyName() 		. "'";
			$sql .= " 	 ,  '" . $this->receiver->GetBarangay() 		. "'";
			$sql .= " 	 ,  '" . $this->receiver->GetCity() 			. "'";
			$sql .= " 	 ,  '" . $this->receiver->GetDistrict() 		. "'";
			$sql .= " 	 ,  '" . $this->receiver->GetContactNo() 		. "'"; 
			$sql .= " 	 ,  'Submitted'";
			$sql .= " 	 ,  '" . $this->suggestion 						. "'";
			$sql .= " 	 ,  '" . $dateToday 							. "'";
			$sql .= " 	 ,  '" . $this->sender->GetName() 				. "'";
			$sql .= " 	 ,  '" . $this->sender->GetHouseNo() 			. "'";
			$sql .= " 	 ,  '" . $this->sender->GetCompanyName() 		. "'";
			$sql .= " 	 ,  '" . $this->sender->GetBarangay() 			. "'";
			$sql .= " 	 ,  '" . $this->sender->GetCity() 				. "'";
			$sql .= " 	 ,  '" . $this->sender->GetDistrict() 			. "'";
			$sql .= " 	 ,  '" . $this->sender->GetContactNo() 			. "'";
			$sql .= " 	 ,  '" . $this->cod->GetBankName() 				. "'";
			$sql .= " 	 ,  '" . $this->cod->GetAccountName() 			. "'";
			$sql .= " 	 ,  '" . $this->cod->GetAccountNo() 			. "'";
			$sql .= " 	 ,  '" . $this->cod->GetAmount() 				. "'";
			$sql .= " 	 ,  ''";
			$sql .= " 	 ,  ''";
			$sql .= " 	 ,  ''";
			$sql .= " 	 ,  ''";
			$sql .= " 	 ,  ''";
			$sql .= " )";
			
			$mysqliQuery = mysqli_query( $connector->GetConnection(), $sql );

			if( $mysqliQuery )
				return array( $referenceNo, true );
			else
				return array( $referenceNo, false );
		}
	}

?>
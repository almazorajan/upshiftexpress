<?php 

    /*
    * interface for Customer
    **/
    interface iCustomer
    {
        public function SetEmailAddress ($value);
        public function SetPassword     ($value);
        public function SetFirstName    ($value);
        public function SetMiddleName   ($value);
        public function SetLastName     ($value);
        public function SetHouseNo      ($value);
        public function SetCompanyName  ($value);
        public function SetBarangay     ($value);
        public function SetCity         ($value);
        public function SetDistrict     ($value);
        public function SetContactNo    ($value);

        public function GetEmailAddress ();
        public function GetPassword     (); 
        public function GetFirstName    (); 
        public function GetMiddleName   ();
        public function GetLastName     (); 
        public function GetHouseNo      (); 
        public function GetCompanyName  (); 
        public function GetBarangay     ();
        public function GetCity         ();
        public function GetDistrict     ();
        public function GetContactNo    ();

        // responsibilities
        public function Add             ();
        public function Update          (); 
    }
    
    /*
    * interface for Shipment
    **/
    interface iShipment
    {
        public function Save ();
        public function EmailSender ();
    }
    
    /*
    * interface for Shipment Service
    **/
    interface iShipmentService
    {
        public function SetLevel    ($value); 
        public function SetSize     ($value); 
        public function SetHeight   ($value);
        public function GetLevel    ();
        public function GetSize     ();
        public function GetHeight   ();
    }
    
    /*
    * interface for Collect on Delivery
    **/
    interface iCollectOnDelivery
    {
        public function SetBankName     ($value);
        public function SetAccountName  ($value);
        public function SetAcccountNo   ($value);
        public function SetAmount       ($value);

        public function GetBankName     ();
        public function GetAccountName  ();
        public function GetAcccountNo   (); 
        public function GetAmount       ();     
    }
    
    Class Customer implements iCustomer
    {

        private $emailaddress;
        private $password;

        private $firstname;
        private $middlename;
        private $lastname;

        private $houseno;
        private $companyname;
        private $barangay;
        private $city;
        private $district;

        private $contactno;

        function __contstruct () { $this->middlename = ""; }


        public function SetEmailAddress ($value) {  $this->emailaddress = $value;   }
        public function SetPassword     ($value) {  $this->password     = $value;   }
        public function SetFirstName    ($value) {  $this->firstname    = $value;   }
        public function SetMiddleName   ($value) {  $this->middlename   = $value;   }
        public function SetLastName     ($value) {  $this->lastname     = $value;   }
        public function SetHouseNo      ($value) {  $this->houseno      = $value;   }
        public function SetCompanyName  ($value) {  $this->companyname  = $value;   }
        public function SetBarangay     ($value) {  $this->barangay     = $value;   }
        public function SetCity         ($value) {  $this->city         = $value;   }
        public function SetDistrict     ($value) {  $this->district     = $value;   }
        public function SetContactNo    ($value) {  $this->contactno    = $value;   }

        public function GetEmailAddress () {    return $this->emailaddress; }
        public function GetPassword     () {    return $this->password;     }
        public function GetFirstName    () {    return $this->firstname;    }
        public function GetMiddleName   () {    return $this->middlename;   }
        public function GetLastName     () {    return $this->lastname;     }
        public function GetHouseNo      () {    return $this->houseno;      }
        public function GetCompanyName  () {    return $this->companyname;  }
        public function GetBarangay     () {    return $this->barangay;     }
        public function GetCity         () {    return $this->city;         }
        public function GetDistrict     () {    return $this->district ;    }

        public function GetContactNo    () {    return $this->contactno;    }

        // responsibilities
        public function Add()
        {
            // Add Customer to the Database
        }

        public function Update()
        {
            // Update Customer to the Database
        }
    }

    Class Shipment implements iShipment
    {
        public  $sender;
        public  $receiver;
        private $declaredval;
        private $description;
        private $service;
        private $insurance;
        private $payment;
        private $cod;

        // constructor
        function __construct () 
        {
            $this->ConstructDefault();
            
            if (func_num_args() == 1)
            {
                 switch (func_get_args(1))
                 {
                    case "Next Day Delivery w/ Collect On Delivery" :
                    case "Same Day Delivery w/ Collect On Delivery" :
                        $this->cod = new CollectOnDelivery();
                    break;
                 }
                 
                 $this->service->setLevel($DeliveryLevel);
            }
        }

        private function ConstructDefault ()
        {
            $this->sender   = new Customer();
            $this->receiver = new Customer();
            $this->service  = new ShipmentService();
        }
        
        public function SetDeclaredValue    ($value) {  $this->declaredval   = $value;  }
        public function SetDescription      ($value) {  $this->description   = $value;  }
        public function SetPayment          ($value) {  $this->payment       = $value;  }
        public function SetInsurance        ($value) {  $this->insurance     = $value;  }
    

        // responsibilites
        public function Save () 
        {

        }

        public function EmailSender () 
        {

        }

        private function GenerateReferenceNo ()
        {

        }

        private function ComputeCost()
        {

        }
    }

    Class ShipmentService implements iShipmentService
    {
        private $level;
        private $size;
        private $height;
        private $length;
        private $width;
        private $weight;
        private $actualweight;
        private $dimension;
        private $chargeableweight;

        public function SetLevel    ($value) {  $this->level    = $value;   }
        public function SetSize     ($value) {  $this->size     = $size;    }
        public function SetHeight   ($value) {  $this->height   = $value;   }

        public function GetLevel    () {    return $this->level;    }
        public function GetSize     () {    return $this->size;     }
        public function GetHeight   () {    return $this->height;   }
    }

    Class CollectOnDelivery implements iCollectOnDelivery
    {
        private $bankname;
        private $accountname;
        private $accountno;
        private $amount;

        public function SetBankName     ($value) {  $this->bankname  = $value;   }
        public function SetAccountName  ($value) {  $this->accountno = $value;   }
        public function SetAcccountNo   ($value) {  $this->accountno = $value;   }
        public function SetAmount       ($value) {  $this->amount    = $value;   }

        public function GetBankName     () {    return $this->bankname;     }
        public function GetAccountName  () {    return $this->accountno;    }
        public function GetAcccountNo   () {    return $this->accountno;    }
        public function GetAmount       () {    return $this->amount;       }
    }
?>
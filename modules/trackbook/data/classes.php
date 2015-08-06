<?php 

	include_once('../../../php/Classes/Connector.php');

	class TrackBookOutput
	{
		public $onlineReferenceNo;
		public $waybillNo;
		public $provincialTrackingNo;
		public $serviceLevel;
		public $size;
		public $sender;
		public $receiver;
		public $latestStatus;
		public $reason;
	}

	class TrackBook
	{
		private $referenceNo;

		public function SetReferenceNo( $value )
		{
			$this->referenceNo = $value;
		} 

		public function TrackBook()
		{

			$connector = new connector();
			
			$sql = "";
			$sql .= " SELECT";
            $sql .= " ReferenceNo";
            $sql .= " , DelSender";
            $sql .= " , DelReceiver";
            $sql .= " , Status";
            $sql .= " , Reason";
            $sql .= " , ServiceLevel";
            $sql .= " , DeliveryBoxSize";
            $sql .= " , WaybillNumber";
            $sql .= " , LBC ";
            $sql .= " FROM booking_details ";
            $sql .= " WHERE";
            $sql .= "   ReferenceNo 	= '" . $this->referenceNo . "' OR ";
            $sql .= "   WaybillNumber 	= '" . $this->referenceNo . "' OR ";
            $sql .= "   LBC 			= '" . $this->referenceNo . "'";
		
            $mysqliQuery 		= mysqli_query($connector->GetConnection(), $sql);
            $counter 			= 0;
            $trackBookOutput 	= new TrackBookOutput();
            $row 				= mysqli_fetch_array($mysqliQuery);
            
            $trackBookOutput->onlineReferenceNo 	= $row["ReferenceNo"];
        	$trackBookOutput->waybillNo 			= $row["WaybillNumber"];
        	$trackBookOutput->provincialTrackingNo 	= $row["LBC"];
        	$trackBookOutput->sender 				= $row["DelSender"];
        	$trackBookOutput->receiver 				= $row["DelReceiver"];
        	$trackBookOutput->latestStatus 			= $row["Status"];
        	$trackBookOutput->reason 				= $row["Reason"];
        	$trackBookOutput->serviceLevel 			= $row["ServiceLevel"];
        	$trackBookOutput->size 					= $row["DeliveryBoxSize"];

            return $trackBookOutput;
		}
	}

?>
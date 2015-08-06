<?php 
	
	include_once('classes.php');

	function TrackBooking( $payload )
	{
		$trackBook = new TrackBook();

		$trackBook->SetReferenceNo( $payload );

		echo json_encode($trackBook->TrackBook());
	}
	
?>
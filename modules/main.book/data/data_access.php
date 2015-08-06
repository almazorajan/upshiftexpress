<?php 
	
	include_once('classes.php');

	function AddBook( $payload ) {

		$book 		= new Book();
		$connector 	= new Connector();
		$conn 		= $connector->GetConnection();
		$payload 	= json_decode( $payload );

		$book->sender->SetName( $payload->sender->name );
		$book->sender->SetHouseNo( $payload->sender->houseNo );
		$book->sender->SetCompanyName( $payload->sender->companyName );
		$book->sender->SetBarangay( $payload->sender->barangay );
		$book->sender->SetCity( $payload->sender->city );
		$book->sender->SetDistrict( $payload->sender->district );
		$book->sender->SetContactNo( $payload->sender->contactNo );

		$book->receiver->SetName( $payload->receiver->name );
		$book->receiver->SetHouseNo( $payload->receiver->houseNo );
		$book->receiver->SetCompanyName( $payload->receiver->companyName );
		$book->receiver->SetBarangay( $payload->receiver->barangay );
		$book->receiver->SetCity( $payload->receiver->city );
		$book->receiver->SetDistrict( $payload->receiver->district );
		$book->receiver->SetContactNo( $payload->receiver->contactNo );
	
		$book->SetServiceLevel( $payload->serviceLevel );
		$book->SetSize( $payload->size );
		$book->SetHeight( $payload->height );
		$book->SetLength( $payload->length );
		$book->SetWidth( $payload->width );
		$book->SetWeight( $payload->weight );
		$book->SetChargeableWeight( $payload->chargeableWeight );
		$book->SetDimension( $payload->dimension );
		$book->SetInsurance( $payload->insurance );
		$book->SetDeclaredValue( $payload->declaredValue );
		$book->SetPaymentMethod( $payload->paymentMethod );

		$payload->cod->bankName 	= isset( $payload->cod->bankName ) 		? $payload->cod->bankName 		: "";
		$payload->cod->accountName 	= isset( $payload->cod->accountName ) 	? $payload->cod->accountName 	: "";
		$payload->cod->accountNo 	= isset( $payload->cod->accountNo ) 	? $payload->cod->accountNo 		: "";
		$payload->cod->amount 		= isset( $payload->cod->amount ) 		? $payload->cod->amount 		: 0;

		$book->cod->SetBankName( $payload->cod->bankName );
		$book->cod->SetAccountName( $payload->cod->accountName );
		$book->cod->SetAccountNo( $payload->cod->accountNo );
		$book->cod->SetAmount( $payload->cod->amount );

		$book->SetAmountDue( $payload->amountDue );

		if( $book->SaveBooking()[1] )
			echo json_encode($book->SaveBooking());
		else
			echo json_encode($book->SaveBooking());
	}
?>

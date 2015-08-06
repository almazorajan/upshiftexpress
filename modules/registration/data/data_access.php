
<?php 
	include_once('classes.php');

	function AddMember( $payload ) {

		$payload = json_decode( $payload );

		$member = new Member();

		$member->SetFirstName( $payload->firstName );
		$member->SetMiddleName( $payload->middleName );
		$member->SetLastName( $payload->lastName );
		$member->SetEmail( $payload->email );
		$member->SetPassword( $payload->password );
		$member->SetStatus( 1 );
		$member->SetContactNo( $payload->contactNo );

		$member->SetHouseNo( $payload->houseNo );
		$member->SetCompanyName( $payload->companyName );
		$member->SetBarangay( $payload->barangay );
		$member->SetCity( $payload->city );
		$member->SetDistrict ( $payload->district );
		
		echo $member->Add();
	};

	function CheckMember( $payload ) {
		$emailChecker = new EmailChecker();
		if( $emailChecker->ValidateEmail( $payload ) )
			echo 'true';
		else  
			echo 'false'; 
			
	};

?>
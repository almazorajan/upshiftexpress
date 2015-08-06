<?php 
	
	include_once('classes.php');

	function UpdateProfile( $payload ) {

		$payload = json_decode( $payload );

		switch( $payload->requestType )
		{
			case 'Update Email':

				$updater = new CustomerEmailUpdater();

				$updater->SetCurrentEmail( $payload->currentEmail );
				$updater->SetNewEmail( $payload->newEmail );
				$updater->SetCurrentPassword( $payload->currentPassword );

				if( $updater->UpdateEmail() )
					echo 'true';
				else
					echo 'false';

			break; // end of update email request

			case 'Update Personal Info':

				$updater = new CustomerPersonalInfoUpdater();

				$payload->middleName = isset( $payload->middleName ) ? $payload->middleName : "";

				$updater->SetCurrentEmail( $payload->currentEmail );
				$updater->SetCurrentPassword( $payload->currentPassword );
				$updater->SetFirstName( $payload->firstName );
				$updater->SetMiddleName( $payload->middleName );
				$updater->SetLastName( $payload->lastName );

				if( $updater->UpdatePersonalInfo() )
					echo 'true';
				else
					echo 'false';

			break; // end of update personal info request

			case 'Update Password':

				$updater = new CustomerPasswordUpdater();

				$updater->SetCurrentEmail( $payload->currentEmail );
				$updater->SetCurrentPassword( $payload->currentPassword );
				$updater->SetNewPassword( $payload->newPassword );
				$updater->SetConfirmNewPassword( $payload->confirmNewPassword );

				if( $updater->UpdatePassword() )
					echo 'true';
				else
					echo 'false';

			break; // end of change password request

			case 'Update Address':

				$updater = new CustomerAddressUpdater();

				$updater->SetCurrentEmail( $payload->currentEmail );
				$updater->SetCurrentPassword( $payload->currentPassword );
				$updater->SetHouseNo( $payload->houseNo );
				$updater->SetCompanyName( $payload->companyName );
				$updater->SetBarangay( $payload->barangay );
				$updater->SetCity( $payload->city );
				$updater->SetDistrict( $payload->district );

				if( $updater->UpdateAddress() )
					echo 'true';
				else
					echo 'false';

			break;

			case 'Update Contact No':

				$updater = new CustomerContactNoUpdater();
				$updater->SetCurrentEmail( $payload->currentEmail );
				$updater->SetCurrentPassword( $payload->currentPassword );
				$updater->SetContactNo( $payload->contactNo );

				if( $updater->UpdateContactNo() )
					echo 'true';
				else
					echo 'false';

			break;
		}
	}
?>

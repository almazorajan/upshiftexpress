<?php 

	include_once('classes.php');

	function GetUserInformation( $payload ) 
	{
		$connector 			= new Connector();
		$payload 			= json_decode( $payload );

		$sql 	= "";
		$sql 	.= " SELECT";
		$sql 	.= " 	 members_info.email";
		$sql 	.= " 	 , members_info.lastname";
		$sql 	.= " 	 , members_info.firstname";
		$sql 	.= " 	 , members_info.middlename";
		$sql 	.= " 	 , members_info.contactno";
		$sql 	.= " 	 , members_info.status";
		$sql 	.= " 	 , members_address.houseno";
		$sql 	.= " 	 , members_address.companyname";
		$sql 	.= " 	 , members_address.barangay";
		$sql 	.= " 	 , members_address.city";
		$sql 	.= " 	 , members_address.district";
		$sql 	.= " FROM members_info";
		$sql 	.= " INNER JOIN members_address ON";
		$sql 	.= " 	members_info.email = members_address.email";
		$sql 	.= " WHERE";
		$sql 	.= "	members_info.email 			= '" . $payload->email . "'";
		$sql 	.= "	AND members_info.password 	= '" . md5( $payload->password ) . "'";

		$mysqliQuery = mysqli_query( $connector->GetConnection(), $sql );

		if( $mysqliQuery )
		{
			echo json_encode(mysqli_fetch_array($mysqliQuery));
		}
		else
		{
			echo 'error';
		}
	}

	function GenerateNewPassword( $payload )
	{
		$passwordGenerator = new PasswordGenerator();
		echo 'test';
		$passwordGenerator->SetCurrentEmail( $payload );

		if( $passwordGenerator->GenerateNewPassword() )
			echo 'true';
		else
			echo 'false';
	}
?>
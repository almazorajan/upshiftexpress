<?php 

	include_once('data_access.php');

	switch( $_SERVER["REQUEST_METHOD"] )
	{
		case 'GET':
			GetUserInformation( $_GET['payload'] );
		break;
		case 'POST':
			GenerateNewPassword( $_POST['payload'] );
		break;
	}

?>
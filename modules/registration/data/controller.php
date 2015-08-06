<?php 
	include_once('data_access.php');

	switch( $_SERVER["REQUEST_METHOD"] )
	{
		case 'GET':
			CheckMember( $_GET['payload'] );
		break;
		case 'POST':
			$postParameter = file_get_contents('php://input');
			AddMember( $postParameter );
		break;
	}

?>
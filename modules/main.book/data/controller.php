<?php 
	include_once('data_access.php');

	switch( $_SERVER["REQUEST_METHOD"] )
	{
		case 'POST':
			$postParameter = file_get_contents('php://input');
			AddBook( $postParameter );
		break;
	}

?>
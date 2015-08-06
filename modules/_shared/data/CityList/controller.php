<?php 
	include_once('data_access.php');

	switch( $_SERVER["REQUEST_METHOD"] )
	{
		case 'GET':
			echo GetServiceableAreaList();
		break;
	}
?>
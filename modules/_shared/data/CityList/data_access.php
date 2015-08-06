<?php 
	
	include_once( 'classes.php' );

	function GetServiceableAreaList()
	{
		$serviceableAreaList = new ServiceableAreaList();

		return $serviceableAreaList->GetServiceableAreaList();
	}

?>
<?php 
	
	include_once( 'classes.php' );

	function GetShippingPrices()
	{
		$shippingPrices = new ShippingPrices();

		return $shippingPrices->GetShippingPrices();
	}

?>
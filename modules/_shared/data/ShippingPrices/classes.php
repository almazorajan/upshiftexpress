<?php 
	
	include_once('../../../../php/Classes/Connector.php');

	class ShippingPrices
	{
		public function GetShippingPrices()
		{
			$connector  		= new Connector();
			$sql  		 		= " SELECT";
			$sql 				.= "	distancefrom";
			$sql 				.= " 	, distanceto";
			$sql 				.= "	, price";
			$sql 				.= " FROM shipping_prices";	
			$mysqliQuery 	  	= mysqli_query( $connector->GetConnection(), $sql );

			$output = array();

			while( $row = mysqli_fetch_array( $mysqliQuery, MYSQLI_ASSOC ) ) 
			{
				array_push( $output, $row );
			}

			return json_encode( $output );
		}
	}
?>

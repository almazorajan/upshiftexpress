<?php 
	
	include_once('../../../../php/Classes/Connector.php');

	class ServiceableAreaList
	{
		public function GetServiceableAreaList()
		{
			$connector = new Connector();
			$sqlCities = "SELECT cityname FROM cities";	
			$mysqliQueryCities = mysqli_query( $connector->GetConnection(), $sqlCities );

			$results = array();
			while ( $row_city = mysqli_fetch_array( $mysqliQueryCities ) ) {
				
				$city = new City();

				$city->cityName = $row_city['cityname'];

				$sqlDistricts = "";
				$sqlDistricts .= " SELECT districtname, class";
				$sqlDistricts .= " FROM district WHERE cityname='" . $city->cityName . "'";

				$mysqliQueryDistricts = mysqli_query( $connector->GetConnection(), $sqlDistricts );

				while ( $row_district = mysqli_fetch_array( $mysqliQueryDistricts ) ) {
					$district = new District();
					$district->districtName = $row_district['districtname'];
					$district->class 		= $row_district['class'];
					array_push( $city->districts, $district );
				}

				array_push( $results, $city );
			
			}

			return json_encode( $results );
		}
	}

	class City
	{
		public $cityName;
		public $districts = array();
	}

	class District
	{
		public $districtName;
		public $class;
	}

?>

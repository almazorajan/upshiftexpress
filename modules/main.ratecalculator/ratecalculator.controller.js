
rateCalculatorModule
.controller('rateCalculatorController', [
	'$scope'
	, 'rateCalculatorAPI'
	, 'book'
	, 'ServiceableArea'
	, 'computeCost'
	, '$alert'
	, function( $scope, rateCalculatorAPI, book, ServiceableArea, computeCost, $alert ) {
		
		$scope.book = new book;

		$scope.serviceLevels 	= [];
		$scope.shippingSizes 	= [];
		$scope.serviceableAreas = [];

		$scope.loading 					= {};
		$scope.loading.serviceLevels 	= false;
		$scope.loading.shippingSizes 	= false;
		$scope.loading.serviceableAreas = false;
		$scope.loading.shippingPrices 	= false;
		loadingResources 				= false;

		$scope.from 					= [];
		$scope.to 						= [];
		$scope.shippingPrices 			= [];
		$scope.fromIndex 				= 0;
		$scope.toIndex 					= 0;

		$scope.computeCost = function() {
			computeCost( $scope.book, $scope.serviceableAreas, $scope.shippingPrices );
		};

		$scope.$watch('loading', function() {

			$scope.loadingResources = $scope.loading.serviceLevels  	 	== false
										&& $scope.loading.shippingSizes  	== false
										&& $scope.loading.serviceableAreas  == false
										&& $scope.loading.shippingPrices  	== false;
						
			if( $scope.loadingResources ) {
				$scope.computeCost();
			}

		}, true);

		$scope.$watch('book', function() {
			$scope.computeCost();

		}, true);

		var onLoad = function() {
			getResources();
		};

		var getResources = function() {

			$scope.loading.serviceLevels 	= true;
			$scope.loading.shippingSizes 	= true;
			$scope.loading.serviceableAreas = true;
			$scope.loading.shippingPrices 	= true;

			rateCalculatorAPI.getServiceLevels().then(function( results ) {

				$scope.serviceLevels 			= results;
				$scope.book.serviceLevel 		= $scope.serviceLevels[0].serviceLevel;
				$scope.loading.serviceLevels 	= false;

			});

			rateCalculatorAPI.getSizes().then(function( results ) {

				$scope.shippingSizes 			= results;
				$scope.book.size 				= $scope.shippingSizes[0].size;

				$scope.loading.shippingSizes 	= false;
			
			});

			ServiceableArea.get().then(function( results ) {

				$scope.serviceableAreas 		= results;

				$scope.from 					= angular.copy($scope.serviceableAreas);
				$scope.to 						= angular.copy($scope.serviceableAreas);

				$scope.book.sender.city 		= $scope.from[0].cityName;
				$scope.book.sender.district 	= $scope.from[0].districts[0].districtName;
				$scope.fromDistricts 			= $scope.from[0].districts;

				$scope.book.receiver.city 		= $scope.to[0].cityName;
				$scope.book.receiver.district 	= $scope.to[0].districts[0].districtName;
				$scope.toDistricts 				= $scope.to[0].districts;

				$scope.loading.serviceableAreas = false;

			});

			rateCalculatorAPI.getShippingPrices().then(function( results ) {
				$scope.shippingPrices 			= results;
				$scope.loading.shippingPrices 	= false;
			});

		};

		$scope.updateDistrict = function( direction, area ) {

			for( var counter = 0; counter < $scope.serviceableAreas.length; counter++ ) {

				if ( area == $scope.serviceableAreas[counter].cityName ) {

					var index = $scope.serviceableAreas.indexOf( $scope.serviceableAreas[counter] );

					if( direction == 'from' ) {
						$scope.fromDistricts 		= $scope.from[index].districts;
						$scope.sender.district 		= $scope.fromDistricts[0].districtName;
						$scope.computeCost();
						return;
					}

					if( direction == 'to' ) {
						$scope.toDistricts 			= $scope.to[index].districts;
						$scope.receiver.district 	= $scope.toDistricts[0].districtName;
						$scope.computeCost();
						return;
					}
				}
			}
		};

		onLoad();
	}
])

	

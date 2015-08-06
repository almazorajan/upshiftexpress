 
bookModule
.controller('bookController', [
	'$scope'
	, 'rateCalculatorAPI'
	, 'book'
	, 'ServiceableArea'
	, 'computeCost'
	, 'localStorageService'
	, '$location'
	, 'bookAPI'
	, function( $scope
				, rateCalculatorAPI
				, book
				, ServiceableArea
				, computeCost
				, localStorageService
				, $location
				, bookAPI ) {

		var currentUser = localStorageService.get('userInformation');

		$scope.isLoggedIn = $location.path() == '/book' ? true : false;

		$scope.book = new book();

		$scope.book.sender.name 		= currentUser.firstname + ' ' + currentUser.middlename + ' ' + currentUser.lastname;
		$scope.book.sender.houseNo 		= currentUser.address.houseno;
		$scope.book.sender.companyName 	= currentUser.address.companyname;
		$scope.book.sender.barangay 	= currentUser.address.barangay;
		$scope.book.sender.district 	= currentUser.address.district;
		$scope.book.sender.city 		= currentUser.address.city;
		$scope.book.sender.contactNo 	= currentUser.contactno;

		$scope.serviceLevels 	= [];
		$scope.shippingSizes 	= [];
		$scope.serviceableAreas = [];

		$scope.loading 					= {};
		$scope.loading.serviceLevels 	= false;
		$scope.loading.shippingSizes 	= false;
		$scope.loading.serviceableAreas = false;
		$scope.loadingResources 		= false;
		$scope.loading.shippingPrices 	= false;

		$scope.from 					= [];
		$scope.to 						= [];
		$scope.shippingPrices 			= [];
		$scope.fromIndex 				= 0;
		$scope.toIndex 					= 0;

		$scope.isCollectOnDelivery 		= false;
		$scope.isProvincialDelivery 	= false;

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

			if( $scope.book.serviceLevel == 'Next Day Delivery w/ Collect On Delivery' || $scope.book.serviceLevel == 'Same Day Delivery w/ Collect On Delivery' )
				$scope.isCollectOnDelivery = true;
			else 
				$scope.isCollectOnDelivery = false;
			

			if( $scope.book.serviceLevel == 'Provincial Delivery')
				$scope.isProvincialDelivery = true;
			else
				$scope.isProvincialDelivery = false;

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
						$scope.fromDistricts 			= [];
						$scope.fromDistricts 			= $scope.from[index].districts;
						$scope.book.sender.district 	= $scope.fromDistricts[0].districtName;
						$scope.computeCost();
						break;
					}

					if( direction == 'to' ) {
						$scope.toDistricts 				= [];
						$scope.toDistricts 				= $scope.to[index].districts;
						$scope.book.receiver.district 	= $scope.toDistricts[0].districtName;
						$scope.computeCost();
						break;
					}
				}
			}
		};

		$scope.$watch('book.serviceLevel', function() {

			var currentTime = parseFloat(moment(new Date()).format('H.m'));
			var cutOff 		= 0;

			if( $scope.book.serviceLevel == 'Next Day Delivery' || $scope.book.serviceLevel == 'Next Day Delivery w/ Collect On Delivery' ) {
				
				if( $scope.book.sender.district == 'Rizal' || $scope.book.receiver.district == 'Rizal' ) {

					cutOff = moment( { hour : 13 } ).format('H');
					if( currentTime >= cutOff )
						swal("Next Day Delivery Cut-off", "You are booking beyond the Cut-off for Rizal area. Do you want to proceed?", "warning");
				
				} else {
					
					cutOff = moment( { hour : 14 } ).format('H');
					if( currentTime >= cutOff )
						swal("Next Day Delivery Cut-off", "You are booking beyond the Cut-off time. Do you want to proceed?", "warning");
				
				}
			}

			if( $scope.book.serviceLevel == 'Same Day Delivery' || $scope.book.serviceLevel == 'Same Day Delivery w/ Collect On Delivery' ) {
				cutOff = moment( { hour : 12 } ).format('H');
					
					if( currentTime >= cutOff )
						swal("Same Day Delivery Cut-off", "You are booking beyond the Cut-off time. You cannot proceed with Same Day Delivery booking. Please change the Service Level.", "error");
			
			}

		}, true);

		$scope.submitBook = function() {

			swal({   
					title: "Submit Book"
					, text: "You do want to submit this booking?"
					, type: "warning"
					, showCancelButton: true
					, confirmButtonText: ""
					, closeOnConfirm: true 
				}
				, 	function( isConfirm ) {   
						$scope.confirmSubmit();
					}
				);
		};

		$scope.confirmSubmit = function() {
			
			if( $scope.isProvincialDelivery ) {
				$scope.book.sender.city 		= $scope.book.sender.provincialCity;
				$scope.book.sender.district 	= $scope.book.sender.provincialDistrict;
				$scope.book.receiver.city 		= $scope.book.receiver.provincialCity;
				$scope.book.receiver.district 	= $scope.book.receiver.provincialDistrict;
			}

			bookAPI.submitBook( $scope.book ).success(function( results ){
				
				if( results[1] == true ) {
					
					swal("Your book was successfully saved!", "Your Reference No is " + results[0],  "success");
					
					$scope.book = new book();
					$scope.book.sender.name 		= currentUser.firstname + ' ' + currentUser.middlename + ' ' + currentUser.lastname;
					$scope.book.sender.houseNo 		= currentUser.address.houseno;
					$scope.book.sender.companyName 	= currentUser.address.companyname;
					$scope.book.sender.barangay 	= currentUser.address.barangay;
					$scope.book.sender.district 	= currentUser.address.district;
					$scope.book.sender.city 		= currentUser.address.city;
					$scope.book.sender.contactNo 	= currentUser.contactno;
					$scope.book.receiver.city 		= $scope.to[0].cityName;
					$scope.book.receiver.district 	= $scope.to[0].districts[0].districtName;
					$scope.book.size 				= $scope.shippingSizes[0].size;
					$scope.book.serviceLevel 		= $scope.serviceLevels[0].serviceLevel;
					$scope.computeCost();
				}
				else
					swal("Ooops!", "There was an error in processing your book. Please try again later.",  "error");

			}).error(function( results ){

			});
		};

		onLoad();
	}
])
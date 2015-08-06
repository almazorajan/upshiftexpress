
'use strict';

trackBookModule
.controller('trackBookController',[
	'$scope'
	, 'trackBookAPI'
	, '$location'
	, function( $scope, trackBookAPI, $location ) {

		$scope.referenceNo 			= '';
		$scope.book 				= {};
		$scope.tableIsEnabled 		= false;
		$scope.loading 				= false;
		$scope.hasSearched 			= false;
		$scope.searchedReferenceNo 	= '';

		$scope.track = function() {

			$scope.loading 			= true;
			$scope.book 			= {};
			$scope.tableIsEnabled 	= false;
			$scope.hasSearched 		= true;
			
			trackBookAPI.trackBook( $scope.referenceNo ).then(function( results ) {
				$scope.book 					= results;
				$scope.tableIsEnabled 			= $scope.book.onlineReferenceNo != null;
				$scope.searchedReferenceNo 		= angular.copy($scope.referenceNo);
				$scope.loading 					= false;
			})
		};
	}
])
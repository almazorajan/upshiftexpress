
'use strict';

congratulationsModule
.controller('congratulationsController', [
	'$scope'
	, '$rootScope'
	, '$location'
	, '$window'
	, function( $scope, $rootScope, $location, $window ) {

		$scope.newMember = {};

		var onLoad = function() {
			checkAuthentication();
			$scope.newMember 		= angular.copy($rootScope.newMember);
			$rootScope.newMember 	= undefined;
		};

		var checkAuthentication = function() {
			if (!$rootScope.newMember)
				$location.path('/registration');
		};

		$scope.redirectToLogin = function() {
			$location.path('/login');
		};

		onLoad();
	}
])
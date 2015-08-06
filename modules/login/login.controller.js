
loginModule
	.controller('loginController', ['$scope', 'localStorageService', '$window', 'loginFactory',
		function ( $scope, localStorageService, $window, loginFactory ) {
	
			$scope.loginSuccessful 		= false;
			$scope.loginUnsuccessful 	= false;

			$scope.credentials 			= {}
			$scope.credentials.email 	= 'jan.almazora@ymail.com';
			$scope.credentials.password = 'testPassword123';

			$scope.forgotPasswordEmail 	= '';

			$scope.login = function () {

				var payload 		= {};
				payload.email 		= $scope.credentials.email;
				payload.password 	= $scope.credentials.password;

				loginFactory.auth(payload).then(function( result ) {
					var userInformation = {};
					if ( !angular.isUndefined( result.email ))  {
						userInformation.email 					= result.email;
						userInformation.firstname 				= result.firstname;
						userInformation.middlename 				= result.middlename;
						userInformation.lastname 				= result.lastname;
						userInformation.address 				= {}
						userInformation.address.houseno 		= result.houseno;
						userInformation.address.companyname 	= result.companyname;
						userInformation.address.barangay 		= result.barangay;
						userInformation.address.city 			= result.city;
						userInformation.address.district 		= result.district;
						userInformation.contactno 				= result.contactno;

						localStorageService.set('userInformation', userInformation);
						beginCountDown();	
					}
					else {
						$scope.loginUnsuccessful = true;
					}
				})	
			};

			$scope.forgotPassword = function() {
				console.log('test');
				loginFactory.forgotPassword( $scope.forgotPasswordEmail ).then(function( result ) {
					console.log( result );
				})
			};

			var time = 1;
			var beginCountDown = function () {
				$scope.loginSuccessful 	= true;
					
				angular.element('#timeout').html(time--);

				if (angular.element('#timeout').html() == 0) $window.location.href = '#/ratecalculator';
				else setTimeout(beginCountDown, 1000);
			};
		}
	])
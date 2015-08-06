
customerProfileModule
.controller('profileController', [
		'$scope'
		, 'tab'
		, 'localStorageService'
		, 'ServiceableArea'
		, 'profileAPI'
		, 'profile'
		, '$location'
		, function( $scope
					, tab
					, localStorageService
					, ServiceableArea
					, profileAPI
					, profile
					, $location ) {

			$scope.tabs = [];
			$scope.tabs.push(new tab( 'Update Email', true ));
			$scope.tabs.push(new tab( 'Update Personal Info' ));
			$scope.tabs.push(new tab( 'Update Password' ));
			$scope.tabs.push(new tab( 'Update Address' ));
			$scope.tabs.push(new tab( 'Update Contact No' ));

			$scope.activeTab = '';

			$scope.userInformation 	= localStorageService.get('userInformation');
			$scope.currentDistricts = [];

			$scope.profile = new profile( angular.copy( $scope.userInformation ) );

			for( var i = 0; i < $scope.tabs.length; i++ ) {
				
				if( $scope.tabs[i].isActive ) {
					$scope.activeTab = $scope.tabs[i].text;
					break;
				}
				
			}

			$scope.showTab = function( tab ) {
				$scope.activeTab = tab.text;

				$scope.profile.currentPassword 		= "";
				$scope.profile.newPassword 			= "";
				$scope.profile.confirmNewPassword 	= "";
			};

			$scope.saveChanges = function() {

				var payload = {};

				payload.requestType 	= angular.copy( $scope.activeTab );
				payload.currentEmail 	= $scope.profile.currentEmail;
				payload.currentPassword = $scope.profile.currentPassword;

				var content = ""; 

				if( $scope.activeTab == 'Update Email' ) {

					payload.newEmail 		= $scope.profile.newEmail;
					payload.currentPassword = $scope.profile.currentPassword;

					content = "email";
				}

				if( $scope.activeTab == 'Update Personal Info' ) {

					payload.firstName 	= $scope.profile.firstName;
					payload.middleName 	= $scope.profile.middleName;
					payload.lastName 	= $scope.profile.lastName;

					content = "personal info";
				}

				if( $scope.activeTab == 'Update Password' ) {

					payload.newPassword 		= $scope.profile.newPassword;
					payload.confirmNewPassword 	= $scope.profile.confirmNewPassword;

					content = "password";
				}

				if( $scope.activeTab == 'Update Address' ) {

					payload.houseNo 	= $scope.profile.houseNo;
					payload.companyName = $scope.profile.companyName;
					payload.barangay 	= $scope.profile.barangay;
					payload.city 		= $scope.profile.city;
					payload.district 	= $scope.profile.district;

					content = "address";
				}

				if( $scope.activeTab == 'Update Contact No' ) {

					payload.contactNo = $scope.profile.contactNo;

					content = "contact number";
				}

				profileAPI.save( payload ).success( function( results ) {
					
					if( results == 'true' ) {

						var option = {};

						var redirect = function(isConfirm) {
							
							if( isConfirm )
								window.location.assign("#/login");

						};

						option.title = "Updated Profile";
						option.text = "You have successfully updated your " + content + ". Please re-login.";
						option.type = "success";
						option.confirmButtonText = "Okay, Let's login again.";

						swal(option, redirect);
					}				
					else
						swal('Ooops', 'Please check your password and try again.', "error");

				})
			};

			$scope.updateDistricts = function( cityName ) {

				for(var i=0; i < $scope.serviceableAreas.length; i++) {

					if( $scope.serviceableAreas[i].cityName == cityName ) {
						$scope.currentDistricts = [];
						$scope.currentDistricts = $scope.serviceableAreas[i].districts;
						$scope.profile.district = $scope.currentDistricts[0].districtName;
						break;
					}

				}
			};

			$scope.loadResources = function() {
				ServiceableArea.get().then(function( results ) {
                    $scope.serviceableAreas = results;
                    
                    for(var i=0; i < $scope.serviceableAreas.length; i++) {

						if( $scope.serviceableAreas[i].cityName == $scope.profile.city ) {
							$scope.currentDistricts = [];
							$scope.currentDistricts = $scope.serviceableAreas[i].districts;
							break;
						}
					}	
                });
			};

			$scope.loadResources();
			swal("Reminder", "After you have updated your information. We may require you to re-login again", "warning");
		}
	]
)
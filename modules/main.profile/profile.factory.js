
customerProfileModule
.factory('tab', function(){

	var tab = function( _text, _isActive ) {
		this.text = _text;
		this.isActive;

		if( _isActive )
			this.isActive = _isActive;
		else
			this.isActive = false;
	};

	return tab;

})

.factory('profile', function() {

	var profile = function( userInformation ) {
		this.currentEmail 	= userInformation.email;
		this.newEmail;
		this.currentPassword;
		this.newPassword;
		this.confirmNewPassword;
		this.firstName 		= userInformation.firstname;
		this.middleName 	= userInformation.middlename;
		this.lastName 		= userInformation.lastname;
		this.houseNo 		= userInformation.address.houseno;
		this.companyName 	= userInformation.address.companyname;
		this.barangay 		= userInformation.address.barangay;
		this.city 			= userInformation.address.city;
		this.district 		= userInformation.address.district;
		this.contactNo 		= userInformation.contactno;
	};

	return profile;
})

.factory('profileAPI', [
	'$http'
	, '$q'
	, function( $http, $q ) {

		var profileAPI 	= {};
		var endpoint 	= "modules/main.profile/data/controller.php";

		profileAPI.save = function( payload ) {
			return $http.post( endpoint, payload );
		};

		return profileAPI;
	}
])
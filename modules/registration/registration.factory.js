
registrationModule
.factory('RegistrationForm', [
	function() {
		
		var customQuestion = function() {
			this.question;
			this.answer;
		};

		var registrationForm = function() {
			this.email 				= 'almazorajan@gmail.com';
			this.password 			= 'testPassword123';
			this.confirmPassword 	= 'testPassword123';
			this.firstName 			= 'Jan';
			this.middleName			= 'Aquino';
			this.lastName 			= 'Almazora';
			this.houseNo 			= '312';
			this.companyName 		= 'G. Pedro St.';
			this.barangay 			= 'New Zaniga';
			this.city;
			this.district;
			this.contactNo 			= '09052111453';
			this.customQuestion 	= new customQuestion();	
		};

		return registrationForm;
	}
])

.factory('EmailValidator', [ '$http', '$q',
	function( $http, $q ) {
		var deferred = $q.defer();
		var endpoint = 'modules/registration/data/controller.php';

		var emailValidator = {};

		emailValidator.checkEmail = function( email ) {
			$http.get( endpoint + '?payload=' + email ).success( deferred.resolve ).error( deferred.reject );

			return deferred.promise;
		};

		return emailValidator;
	}
])

.factory('RegistrationAPI', [ '$http', '$q',
	 function( $http, $q ) {
	 	
	 	var endpoint = 'modules/registration/data/controller.php';

	 	var registrationAPI = {};

	 	registrationAPI.submitForm = function( _form ) {
	 		return $http.post( endpoint, _form )
	 	};

	 	return registrationAPI;
	}
])

.factory('QuestionList', function() {

	var filter = function( text ) {
		var obj 	= {};
		obj.text 	= text;
		obj.value 	= text;

		return obj;
	};

	var questionList = [];

	questionList.push( filter( 'What was the make and model of your first car?' ) );
	questionList.push( filter( 'Who was the president of the Philippines in 1902?' ) );
	questionList.push( filter( "What is your father's name?" ) );
	questionList.push( filter( 'Who is your bestfriend?' ) );

	return questionList;
})
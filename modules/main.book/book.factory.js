
bookModule
.factory('bookAPI', ['$http', '$q',
	function( $http, $q ) {

		var bookAPI = {};

		bookAPI.submitBook = function( book ) {
			var defer = $q.defer();

			return $http.post( 'modules/main.book/data/controller.php', book );
		};

		return bookAPI;
	}
])

.factory('authFactory', ['$location',
	function( $location ) {

		var hasCurrentUser = function( currentUser ) {
			return ( currentUser == null || currentUser == "" ? false : true );
		};

		var redirectToLogin = function () {
			$location.path('/login');
		};

		var authFactory  			= {}
		authFactory.hasCurrentUser 	= hasCurrentUser;
		authFactory.redirectToLogin = redirectToLogin;
		return authFactory;
	}
])
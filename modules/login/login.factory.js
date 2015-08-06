
loginModule
.factory('loginFactory', ['$http', '$q', 
	function( $http, $q ) {

		var loginFactory = {}

		loginFactory.auth = function( login ) {			
			
			var deferred = $q.defer();
			var loginUrl = 'modules/login/data/controller.php?payload=' + JSON.stringify( login );
			
			$http.get( loginUrl )
				.success( deferred.resolve )
				.error( deferred.reject );

			return deferred.promise;
		};

		loginFactory.forgotPassword = function( email ) {

			var deferred = $q.defer();
			
			$http.post( 'modules/login/data/controller.php?payload=' + email )
				.success( deferred.resolve )
				.error( deferred.reject );

			return deferred.promise; 

		};

		return loginFactory;
	}
])

'use strict';

trackBookModule
.factory('trackBookAPI', [
	'$http'
	, '$q'
	, function( $http, $q ) {

		var trackBookAPI 	= {};
		var baseUrl 		= 'modules/trackbook/data/controller.php';

		trackBookAPI.trackBook = function( referenceNo ) {
			var deferred = $q.defer();
			var endpoint = baseUrl + '?payload=' + referenceNo;

			$http.get(endpoint)
				.success( deferred.resolve )
				.error( deferred.reject )

			return deferred.promise;
		};

		return trackBookAPI;
	}
])
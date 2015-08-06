
app
.factory('ServiceableArea', [ '$http', '$q',
	function ( $http, $q ) {
		var deferred 	= $q.defer();
		var endpoint 	= 'modules/_shared/data/CityList/controller.php';

		var serviceableArea = {};

		serviceableArea.get = function() {
			$http.get(endpoint).success(deferred.resolve).error(deferred.reject);
			return deferred.promise;
		};

		return serviceableArea;
	}
])
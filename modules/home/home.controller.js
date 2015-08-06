

homeModule
.controller('servicesController', ['$scope', 'serviceFactory',
	function( $scope, serviceFactory ) {

		serviceFactory.getServiceList().success(function (data) {
			$scope.services = data;
		})
	}
])

.controller('faqsController', ['$scope', 'faqsFactory',
	function( $scope, faqsFactory ) {
		faqsFactory.getFaqs().success(function (data) {
			$scope.faqs = data;
		})
	}	
]);
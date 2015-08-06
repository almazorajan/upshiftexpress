
homeModule
	.factory('serviceFactory', ['$http',
		function ($http) {
			var serviceUrl = 'js/json/services.json';
			var serviceFactory = {}
			var getServiceList = function () {
				return $http.get(serviceUrl);
			}

			serviceFactory.getServiceList = getServiceList;

			return serviceFactory;
		}
	])

	.factory('faqsFactory', ['$http',
		function ($http) {
			var faqsUrl = 'js/json/faqs.json';

			var getFaqs = function () {
				return $http.get(faqsUrl);
			}

			var faqsFactory = {}

			faqsFactory.getFaqs = getFaqs;

			return faqsFactory;
		}
	])
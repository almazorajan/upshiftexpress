
rateCalculatorModule
.factory('rateCalculatorAPI', ['$http', '$q',
	function( $http, $q ) {

		var rateCalculatorAPI = {}

		rateCalculatorAPI.getServiceLevels = function () {
			
			var deferred = $q.defer();
            $http.post('js/json/servicelevels.json')
            	.success(deferred.resolve)
            	.error(deferred.reject);
            
            return deferred.promise;
		};

		rateCalculatorAPI.getSizes = function () {

			var deferred = $q.defer();
            $http.post('js/json/sizes.json')
            	.success(deferred.resolve)
            	.error(deferred.reject);

            return deferred.promise;
		};

		rateCalculatorAPI.getServiceableAreas = function () {
			
			var deferred = $q.defer();
            $http.post('php/Operators/ListOfCities.php')
            	.success(deferred.resolve)
            	.error(deferred.reject);

            return deferred.promise;
		};

		rateCalculatorAPI.getShippingPrices = function () {
			
			var deferred = $q.defer();
            $http.get('modules/_shared/data/ShippingPrices/controller.php')
            	.success(deferred.resolve)
            	.error(deferred.reject);
            	
            return deferred.promise;
		};

		return rateCalculatorAPI;
	}
])

.factory('book', function(){
	
	var customer = function() {
		this.email;
		this.name;
		this.houseNo;
		this.companyName;
		this.barangay;
		this.city;
		this.district;
		this.provincialCity;
		this.provincialDistrict;
		this.contactNo;
	};

	var collectOnDelivery = function() {
		this.bankName;
		this.accountName;
		this.accountNo;
		this.amount;
	};

	var book = function() {
		this.sender 		= new customer();
		this.receiver 		= new customer();
		this.serviceLevel;
		this.paymentMethod 		= 'Pick-up';
		this.cod 				= new collectOnDelivery();
		this.size;
		this.height 			= 0;
		this.length 			= 0;
		this.width 				= 0;
		this.dimension 			= 0;
		this.weight 			= 0;
		this.chargeableWeight 	= 0;
		this.declaredValue 		= 0;
		this.insurance 			= 0;
		this.amountDue 			= 0;
	};
	

	return book;
})

.factory('computeCost', [
	function() {
	
		var computeInsurance = function( declaredValue ) {

			var insurance = declaredValue - 500;

			if( insurance <= 0 )
				return 0;
			else
				return Math.ceil( insurance * 0.01 );

		};

		var isWithCollectOnDelivery = function( serviceLevel ) {

			if( serviceLevel == 'Next Day Delivery w/ Collect On Delivery' )
				return true;
			else
				return false;

		};

		var computeTotalAmountDue = function( shippingPrice, book ) {

			var amountDue = shippingPrice + book.insurance;

			if( isWithCollectOnDelivery( book.serviceLevel ) )
				amountDue += 20;

			book.amountDue = amountDue;
			return;
		};

		var getClass = function( district, serviceableAreas ) {

			var currentDistrict = null;

			for( var i = 0; i < serviceableAreas.length; i++ ) {
				for( var j = 0; j < serviceableAreas[i].districts.length; j++ ) {
					currentDistrict = serviceableAreas[i].districts[j];

					if( district == currentDistrict.districtName ) {
						return currentDistrict.class;
					}
				} 
			}
		};

		var getSameDayPrice = function( senderClass, receiverClass, shippingPrices ) {

			var cond1 = null;
			var cond2 = null;
			var price = 0;

			for( var i=0; i < shippingPrices.length; i++ ) {

				cond1 = senderClass 	== shippingPrices[i].distancefrom;
				cond2 = receiverClass 	== shippingPrices[i].distanceto;
				price = shippingPrices[i].price;

				if( cond1 && cond2 ) {
					return price;
				}
			};
		};

		var computeCost = function( book, serviceableAreas, shippingPrices ) {

			book.weight 			= Math.ceil( book.weight );
			book.dimension 			= Math.ceil( ( book.height * book.length * book.width ) / 3500 );

			book.chargeableWeight 	= ( book.dimension > book.weight ? book.dimension : book.weight );
			book.insurance 			= computeInsurance( book.declaredValue );

			var shippingPrice 		= 0.00;
			var weightCharge 		= 0.00;
			var additionalCharge 	= 0.00;
			var additionalKilo 		= 0.00;
			var codCharge 			= 20.00;

			var isSameDayDelivery 		= book.serviceLevel == 'Same Day Delivery' || book.serviceLevel == 'Same Day Delivery w/ Collect On Delivery';
			var isNextDayDelivery 		= book.serviceLevel == 'Next Day Delivery' || book.serviceLevel == 'Next Day Delivery w/ Collect On Delivery';
			var isProvincialDelivery 	= book.serviceLevel == 'Provincial Delivery';

			senderClass 	= getClass( book.sender.district, serviceableAreas );
			receiverClass 	= getClass( book.receiver.district, serviceableAreas );
			sameDayPrice 	= parseFloat( getSameDayPrice( senderClass, receiverClass, shippingPrices ) );

			if( isNextDayDelivery ) {

				additionalCharge = 20.00;

				/*
				* [START] Next Day Delivery
				* Manila - Rizal ( Vice Versa )
				**/
				if( book.sender.district == 'Rizal' || book.receiver.district == 'Rizal' ) {

					/*
					* [START] from Rizal to Rizal
					**/
					if(book.sender.district == 'Rizal' && book.receiver.district == 'Rizal' ) {

						if( book.size == 'ShiftPAC-Small' )
							shippingPrice = 40.00;

						if( book.size == 'ShiftPAC-Large' )
							shippingPrice = 60.00;

						if( book.size == 'CustomPAC' ) {

							shippingPrice = 60.00;

							if( book.chargeableWeight > 3 )
								additionalKilo = book.chargeableWeight - 3;

							weightCharge = additionalCharge * additionalKilo;

						}

						shippingPrice += weightCharge;
						computeTotalAmountDue(shippingPrice, book);
					}
					/*
					* [END] from Rizal to Rizal
					**/

					/*
					* [START] From Rizal to Metro Manila
					**/
					if( book.sender.district == 'Rizal' ) {

						if( book.size == 'ShiftPAC-Small' )
							shippingPrice = 40.00;

						if( book.size == 'ShiftPAC-Large' )
							shippingPrice = 60.00;

						if( book.size == 'CustomPAC' ) {

							shippingPrice = 60.00;

							if( book.chargeableWeight > 3 )
								additionalKilo = book.chargeableWeight - 3;

							weightCharge = additionalCharge * additionalKilo;

						}

						shippingPrice += weightCharge;
						computeTotalAmountDue();
						return;
					}
					/*
					* [END] From Rizal to Metro Manila
					**/

					/*
					*	[START] From Metro Manila to Rizal
					**/
					if( book.receiver.district == 'Rizal' ) {

						if( book.size == 'ShiftPAC-Small' )
							shippingPrice = 75.00;

						if( book.size == 'ShiftPAC-Large' )
							shippingPrice = 130.00;

						if( book.size == 'CustomPAC' ) {

							shippingPrice = 130.00;

							if( book.chargeableWeight > 3 )
								additionalKilo = book.chargeableWeight - 3;

							weightCharge = additionalCharge * additionalKilo;

						}

						shippingPrice += weightCharge;
						computeTotalAmountDue();
						return;
					}
					/*
					*	[END] From Metro Manila to Rizal
					**/

					return;
				}
				/*
				* [END] Next Day Delivery
				* Manila - Rizal ( Vice Versa )
				**/

				/*
				* [START] Normal Next Day Delivery
				**/
				if( book.size == 'ShiftPAC-Small' )
					shippingPrice = 40.00;

				if( book.size == 'ShiftPAC-Large' )
					shippingPrice = 60.00;

				if( book.size == 'CustomPAC' ) {
					shippingPrice = 60.00;

					if( book.chargeableWeight > 3 )
						additionalKilo = book.chargeableWeight - 3;

					weightCharge = additionalCharge * additionalKilo;					
				}

				shippingPrice += weightCharge;
				computeTotalAmountDue(shippingPrice, book);
				return;
				/*
				* [END] Normal Next Day Delivery
				**/
			}
			/*
			* [END] Next Day Delivery
			**/

			if( isSameDayDelivery ) {

				additionalCharge = 10;

				if( book.size == 'ShiftPAC-Small' )
					shippingPrice = sameDayPrice;

				if( book.size == 'ShiftPAC-Large' )
					shippingPrice = sameDayPrice + 20;

				if( book.size == 'CustomPAC' ) {
					shippingPrice 	= sameDayPrice + 50.00;
					additionalKilo 	= book.chargeableWeight;
					weightCharge 	= additionalCharge * additionalKilo;
				}

				shippingPrice += weightCharge;
				computeTotalAmountDue(shippingPrice, book);
				return;
			}	
			/*
			* [END] Same Day Delivery
			**/

			if ( isProvincialDelivery ) {

				additionalCharge = 50;

				if( book.size == 'ShiftPAC-Small' )
					shippingPrice = 105;

				if( book.size == 'ShiftPAC-Large' || book.size == 'CustomPAC' ) {
					shippingPrice 	= 165.00;
				}

				if( book.chargeableWeight > 1 ) {
					additionalKilo 	= book.chargeableWeight - 1;
					shippingPrice 	+= additionalKilo * additionalCharge;
				}

				computeTotalAmountDue(shippingPrice, book);
				return;
			}
			/*
			* [END] Provincial Delivery
			**/		
		};
		/* end of Compute Cost function */

		return computeCost;
	}
])
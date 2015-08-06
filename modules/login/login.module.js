
'use strict';

var loginModuleDependencies = [];

loginModuleDependencies.push('LocalStorageModule');

var loginModule = angular.module('loginModule', loginModuleDependencies);

loginModule.run(['localStorageService', '$location',
	function( localStorageService, $location ) {

		var userInformation = localStorageService.get('userInformation');

		// if (userInformation != null || userInformation != undefined)
		// 	$location.url('ratecalculator');
	}
])

// loginModule.run(['localStorageServiceProvider', 'localStorageService',
// 	function (localStorage, localStorageService) {
// 		localStorage.setStorageType('sessionStorage');

// 		if (!localStorageService.isSupported)
// 			localStorage.setStorageType('localStorage');
// 	}
// ]);
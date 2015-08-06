/*
filename: app.js
description: this file is used for routing
*/

var dependencies = [];

dependencies.push('ngRoute');
dependencies.push('ngSanitize');
dependencies.push('bookModule');
dependencies.push('trackBookModule');
dependencies.push('customerProfileModule');
dependencies.push('homeModule');
dependencies.push('loginModule');
dependencies.push('registrationModule');
dependencies.push('congratulationsModule');
dependencies.push('mgcrea.ngStrap');
dependencies.push('rateCalculatorModule');
dependencies.push('ngAnimate');

var app = angular.module('app', dependencies);

app.run(['$window', '$rootScope', '$location',
	function( $window, $rootScope, $location ) {	
    	$window.scrollTo(0, 0);
    	$rootScope.$watch(function() { 
      		return $location.path(); 
	    },
	    function(a){  
	    	new WOW().init();
	    });
	}
]);

app.config(['$routeProvider', '$alertProvider', 
	function( $routeProvider, $alertProvider ) {

		new WOW().init();

		var dir 			= {};
		dir.home 			= 'modules/home/views/';
		dir.login 			= 'modules/login/views/';
		dir.registration 	= 'modules/registration/views/';
		dir.congratulations = 'modules/congratulations/views/';
		dir.book 			= {};
		dir.book.book 		= 'modules/main.book/views/';
		dir.book.rc 		= 'modules/main.ratecalculator/views/';
		dir.book.profile 	= 'modules/main.profile/views/';
		dir.shared			= 'modules/_shared/';
		
		$routeProvider.
			when('/home', {
				templateUrl: dir.home + 'index.html'
			}).
			when('/news', {
				templateUrl: dir.home + 'news.html'
			}).
			when('/about', {
				templateUrl: dir.home + 'about.html'
			}).
			when('/services', {
				templateUrl: dir.home + 'services.html',
				controller: 'servicesController'
			}).
			when('/faqs', {
				templateUrl: dir.home + 'faqs.html',
				controller: 'faqsController'
			}).
			when('/login', {
				templateUrl: dir.login + 'login.html',
				controller: 'loginController'
			}).
			when('/register', {
				templateUrl: dir.registration + 'registration.html',
				controller: 'registrationController'
			}).
			when('/track', {
				templateUrl: dir.shared + 'track.html',
				controller : 'trackBookController'
			}).
			when('/ratecalculator', {
				templateUrl: dir.book.rc + 'ratecalculator.html',
				controller: 'rateCalculatorController'
			}).
			when('/book', {
				templateUrl: dir.book.book + 'book.html',
				controller: 'bookController'
			}).
			when('/profile', {
				templateUrl: dir.book.profile + 'profile.html',
				controller: 'profileController'
			}).
			when('/congratulations', {
				templateUrl: dir.congratulations + 'congratulations.html',
				controller: 'congratulationsController'
			}).
			otherwise({
				redirectTo: '/home'
			});
		// [end] $routeProvider
	}
]);

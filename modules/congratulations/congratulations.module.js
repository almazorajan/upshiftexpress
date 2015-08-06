
'use strict';

var congratulationsModule = angular.module('congratulationsModule', []);

congratulationsModule.run(function( $window ) {
	$window.scrollTo(0, 0);
})
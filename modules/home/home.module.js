
'use strict';

var homeModule = angular.module('homeModule', []);

homeModule.run(function( $window ) {
	$window.scrollTo(0, 0);
})
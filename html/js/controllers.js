'use strict';

/* Controllers */

var eventspireControllers = angular.module('eventspireControllers', []);

eventspireControllers.controller('EventSpireListCtrl', ['$scope', '$rootScope', '$http',  function($scope, $rootScope, $http){
    
    //$scope.url = 'SearchResponse.json';
	$scope.query = "Metallica";
    $scope.userLat = '-6.5';
    $scope.userLng = '53.5';

    $scope.getGeoCode = function(a, b){

    	return a+","+b;
    };
    
    
	
	//$scope.searchInit = function () {
	//    $scope.search();
	//}

	$rootScope.bodyClass = 'homepage';
	
    $scope.search = function() {
		$rootScope.LM = true;

		$scope.url = 'http://search.eventspi.re/search/' + $scope.keywords + '/' + $scope.userLat +'/' + $scope.userLng;
		$http.get($scope.url, { "data" : $scope.keywords}).
		success(function(data, status) {
			$scope.status = status;
			$scope.data = data;
			$rootScope.bodyClass = 'graybg';
			$scope.result = data.Deals;
			console.log(data);
			$rootScope.LM = false;
		})
		.error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;		
			$rootScope.LM = false;	
		});
	};

}]);

eventspireControllers.controller('EventSpireDetailCtrl', ['$scope', '$routeParams', 'eventspireEvents',
  function($scope, $routeParams, Events) {
    $scope.events = Events.get({eventId: $routeParams.phoneId}, function(events) {
      $scope.mainImageUrl = events.images[0];
    });

    $scope.setImage = function(imageUrl) {
      $scope.mainImageUrl = imageUrl;
    }

    $scope.getGeoCode = function(a, b){

    	return a+","+b;
    };
  }]);

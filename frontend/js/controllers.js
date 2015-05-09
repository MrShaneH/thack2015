'use strict';

/* Controllers */

var eventspireControllers = angular.module('eventspireControllers', []);

eventspireControllers.controller('EventSpireListCtrl', ['$scope', '$http', function($scope, $http){
    
    $scope.url = 'SearchResponse.json';

    $scope.search = function() {
		
		$http.get($scope.url, { "data" : $scope.keywords}).
		success(function(data, status) {
			$scope.status = status;
			$scope.data = data;
			$scope.result = data;
		})
		.
		error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;			
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
  }]);

'use strict';

/* App Module */

var eventspireApp = angular.module('eventspireApp', ['ngRoute','eventspireControllers', 'ui.bootstrap', 'ngMap']);

eventspireApp.config(['$routeProvider', function($routeProvider) {
    $routeProvider.
      when('/results', {
        templateUrl: 'partials/results-list.html',
        controller: 'EventSpireListCtrl'
      }).
      when('/results/:eventId', {
        templateUrl: 'partials/result-detail.html',
        controller: 'EventSpireDetailCtrl'
      }).
     when('/', {
      templateUrl: 'partials/search.html',
      controller: 'EventSpireListCtrl'
    }).
      otherwise({
        redirectTo: '/'
      });
  }]);
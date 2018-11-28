var app = angular.module('myApp', ['ngRoute']);

app.config(function($routeProvider) {
  $routeProvider

    .when('/result', {
    templateUrl : '../pages/browse-result.php',
    controller  : 'SearchController'
  })

  .otherwise({redirectTo: '/'});
});

app.controller('SearchController', function($scope) {
  $scope.searchvalue = "";
});

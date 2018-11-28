var result;
var app = angular.module('myApp', []);

app.controller('SearchController', ['$scope', '$http', function($scope, $http) {
  $scope.searchvalue = "";
  $scope.searchresult = "";
  $scope.records = [
          'Alfreds Futterkist',
          'Berglunds snabbköp',
          'Centro comercial Moctezuma',
          'Ernst Handel'
      ];
  $scope.search = function() {
    url = "../php/searchbook.php?searchvalue=" + $scope.searchvalue;
    $http.get(url)
      .then(function(response) {
          $scope.searchresult = response.data;
      });
    };
}]);

function searchbook(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      result = JSON.parse(this.responseText);
      console.log(result)
    }
  };
  xmlhttp.open("GET","../php/searchbook.php",true);
  xmlhttp.send();
}

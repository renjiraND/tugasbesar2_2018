var result;
var app = angular.module('myApp', []);

app.controller('SearchController', ['$scope', '$http', function($scope, $http) {
  $scope.searchvalue = "";
  $scope.searchresult = "";

  $scope.search = function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        result = JSON.parse(this.responseText);
        //result = this.responseText;
        $scope.searchresult = result;
        console.log(result);
        $scope.$apply();
      }
    };
    url = "../php/searchbook.php?searchvalue=" + $scope.searchvalue;
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
  }
  // $scope.search = function() {
  //   url = "../php/searchbook.php?searchvalue=" + $scope.searchvalue;
  //   $http.get(url)
  //     .then(function(response) {
  //         $scope.searchresult = response.data;
  //     });
  //   };
}]);

function searchbook(){

}

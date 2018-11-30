var result;
var app = angular.module('myApp', []);

app.controller('SearchController', ['$scope', '$http', function($scope, $http) {
  $scope.searchvalue = "";
  $scope.searchresult = "";

  $scope.search = function() {
    if (document.getElementById('search-value').value.length==0) {
      alert('Search box must be filled!');
    } else {
      document.getElementById('loading').classList.remove("hide");
      document.getElementById('resulttext').classList.add("hide");
      $scope.searchresult = "";
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if (!this.responseText) {
            document.getElementById('loading').classList.add("hide");
            document.getElementById('resulttext').classList.remove("hide");
            document.getElementById('bookfound').innerHTML = "No Result Found!";
          } else {
            result = JSON.parse(this.responseText);
            //result = this.responseText;
            document.getElementById('loading').classList.add("hide");
            document.getElementById('resulttext').classList.remove("hide");
            document.getElementById('bookfound').innerHTML = "Found " + result.length + " Result(s)";
            $scope.searchresult = result;
            //console.log(result);
            $scope.$apply();
          }
        }
      };
      url = "../php/searchbook.php?searchvalue=" + $scope.searchvalue;
      xmlhttp.open("GET",url,true);
      xmlhttp.send();
    }
  }
}]);

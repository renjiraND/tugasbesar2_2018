<!doctype html>
<html>
  <head>
    <title>Pro Book</title>
  	<link rel="stylesheet" type="text/css" href="../css/app.css">
  	<link rel="stylesheet" type="text/css" href="../css/browse.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-route.min.js"></script>
  </head>
  <body>
    <?php require 'header.php';?>

    <div ng-app="myApp" ng-controller="SearchController" class="padding-large">
      <div class="text-color-orange text-bold text-size-very-large font-default">Search Book</div>
      <div class="margin-top-large">
        <form ng-submit="search()">
          <input ng-model="searchvalue" id="search-value" class="input-search padding-left-small border-radius font-default" type="text" name="search" placeholder="Input search terms...">
          <div class="flex align-right">
            <input id="btn-search" class="text-color-white border-radius bg-color-light-blue margin-top-medium btn-search font-default" type="submit" value="Search">
          </div>
        </form>

        <div ng-repeat="book in searchresult">
          <div class="margin-bottom-medium">
            <div class="flex row margin-top-large">
              <img class="book-result-img" ng-src="{{book.imageLinks}}" style="flex-grow: 1; flex-basis: 0;">
              <div class="margin-left-small font-default" style="flex-grow: 7; flex-basis: 0;">
                <div class="text-color-orange text-bold text-size-medium">{{book.title}}</div>
                <div class="text-color-grey text-bold text-size-very-small">{{book.authors}} - 0.0/5.0</div>
                <div class="text-color-grey text text-size-very-small">{{book.description}}</div>
              </div>
            </div>
            <div>
              <form method="GET" action="browse-detail.php">
                <div class="flex align-right">
                  <input type="hidden" name="id" ng-value="book.id">
                  <!--input type="hidden" name="rating" value="" . $book["rate"] . ""-->
                  <input class="text-color-white border-radius bg-color-light-blue margin-top-small font-default btn-detail" type="submit" value="Detail">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>



  </body>
  <footer></footer>
</html>
<script src="../js/browse.js"></script>
<script src="../js/searchbook.js"></script>
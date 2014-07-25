App.controller('BooksExportedCtrl', ['$scope','Books','$routeParams','Notify','Categories','NavigationService', function ($scope,Books,$routeParams,Notify,Categories,NavigationService) {
    NavigationService.setPageTitle('Cahiers en ligne');
	
	$scope.categories = Categories.get();
    $scope.books = Books.get(0);

    // sorting
    $scope.sorting = 'id';
    $scope.reverse = false;
    
}]);
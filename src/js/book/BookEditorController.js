App.controller('BookEditorCtrl', ['$scope','Books','navService','$routeParams','Notify', function ($scope,Books,navService,$routeParams,Notify) {
    $scope.book = Books.getById($routeParams.book_id);
    $('link.template').attr('href',"src/templates/"+$scope.book.theme.src+".css");
}]);
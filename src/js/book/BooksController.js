App.controller('BooksCtrl', ['$scope','Books','navService','$routeParams','Notify','Categories', function ($scope,Books,navService,$routeParams,Notify,Categories) {
   
    var categories = Categories.get();
    $scope.cat_id = $routeParams.book_id;
    $scope.books = Books.get($routeParams.book_id);

    $scope.deleteBook=function(id){
        for(var i in $scope.books){
            if($scope.books[i].id==id){
                $scope.books.splice(i,1);
                Notify('success','Cahier supprimé','Le cahier a été supprimé avec succès');
            }
        }
        Books.saveLocal($scope.books);
    }

    $scope.cat_name=categories.books[$scope.cat_id].title;
    $scope.button_rename=false;
    $scope.toggleRenameInput=function(){
        $scope.button_rename=!$scope.button_rename;
        if($scope.button_rename==true)
            $scope.$broadcast('inputRenameShown');
    }

    $scope.changeCategoryName=function(e){
        if(e.which === 13 || e.type == "click" && $scope.cat_name != ""){
            categories.books[$scope.cat_id].title=$scope.cat_name;
            Categories.saveLocal(categories);
            $scope.toggleRenameInput();
        }
    }
}]);
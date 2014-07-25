App.controller('BooksCtrl', ['$scope','Books','$routeParams','Notify','Categories','$timeout','$location','NavigationService', function ($scope,Books,$routeParams,Notify,Categories,$timeout,$location,NavigationService) {
    
    NavigationService.setPageTitle('Cahiers');

    for(var i in $scope.books)
        $scope.books[i].visible=false;

    $timeout(function(){

         angular.forEach($scope.books, function(p, i) {
           $timeout(function(){
                $scope.books[i].visible='visible';
            },i*50);
         });

    },200);

    var categories = Categories.get();
    $scope.cat_id = $routeParams.book_id;
    $scope.books = Books.get($routeParams.book_id);

    // sorting
    $scope.sorting = 'id';
    $scope.reverse = false;

    $scope.deleteBook=function(id){

        Notify('question','Voulez-vous vraiment supprimer ce cahier ?',{question:'Vous vous apprêtez à supprimer un cahier. Cette action est irréversible. Voulez-vous vraiment faire ça ?',yes:'Oui',no:'non'});

        $scope.$on('clickDialog',function(e,choice){
            Notify('close');
            if(choice.choice == "yes"){

                Books.delete(id);

                // Delete from display
                for(var i in $scope.books){
                    if($scope.books[i].id==id){
                        $scope.books.splice(i,1);
                        Notify('success','Cahier supprimé','Le cahier a été supprimé avec succès');
                    }
                }
            }
        });
    };

    var ok = false;
    for (var i2 in categories.books){
        if(categories.books[i2].id==$scope.cat_id){
            ok=i2;
            NavigationService.setPageTitle('Cahiers | '+categories.books[i2].title);
        }
    }

    if(!ok){
        $location.path('books/0');
        Notify('error',"Cette catégorie n'existe pas","La catégorie à laquelle vous tentez d'accéder n'existe pas");
        return false;
    }

    $scope.cat_name=categories.books[$scope.cat_id].title;
    $scope.button_rename=false;

    $scope.toggleRenameInput=function(){
        $scope.button_rename=!$scope.button_rename;
        if($scope.button_rename===true)
            $scope.$broadcast('inputRenameShown');
    };

    $scope.changeCategoryName=function(e){
        if(e.which === 13 || e.type == "click" && $scope.cat_name !== ""){
            categories.books[$scope.cat_id].title=$scope.cat_name;
            Categories.saveLocal(categories);
            $scope.toggleRenameInput();
        }
    };
}]);
App.controller('ProjectsCtrl', ['$scope','Projects','$routeParams','Notify','Categories', function ($scope,Projects,$routeParams,Notify,Categories) {

    var categories = Categories.get();
    $scope.cat_id = $routeParams.project_id;
    $scope.projects = Projects.get($routeParams.project_id);

    $scope.deleteProject=function(id){
        for(var i in $scope.projects){
            if($scope.projects[i].id==id){
                $scope.projects.splice(i,1);
                Notify('success','Projet supprimé','Le projet a été supprimé avec succès');
            }
        }
        Projects.saveLocal($scope.projects);
    };

    $scope.cat_name=categories.projects[$scope.cat_id].title;
    $scope.button_rename=false;
    $scope.toggleRenameInput=function(){
        $scope.button_rename=!$scope.button_rename;
        if($scope.button_rename===true)
            $scope.$broadcast('inputRenameShown');
    };

    $scope.changeCategoryName=function(e){
        if(e.which === 13 || e.type == "click" && $scope.cat_name !== ""){
            categories.projects[$scope.cat_id].title=$scope.cat_name;
            Categories.saveLocal(categories);
            $scope.toggleRenameInput();
        }
    };

}]);

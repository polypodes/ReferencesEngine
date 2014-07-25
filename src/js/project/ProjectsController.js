App.controller('ProjectsCtrl', ['$scope','Projects','$routeParams','Notify','Categories','$timeout','$location','NavigationService', function ($scope,Projects,$routeParams,Notify,Categories,$timeout,$location,NavigationService) {
    NavigationService.setPageTitle('Projets');

    // Animation
    for(var i in $scope.projects)
        $scope.projects[i].visible=false;

    $timeout(function(){

         angular.forEach($scope.projects, function(p, i) {
           $timeout(function(){
                $scope.projects[i].visible='visible';
            },i*50);
         });

    },200);

    var categories = Categories.get();
    $scope.cat_id = $routeParams.project_id;
    $scope.projects = Projects.get($routeParams.project_id);

    $scope.sorting = 'id';
    $scope.reverse = false;

    $scope.deleteProject=function(id){

        Notify('question','Voulez-vous vraiment supprimer ce projet ?',{question:'Vous vous apprêtez à supprimer un projet. Il sera également supprimé de tous les cahiers dans lesquels il a été ajouté. Cette action est irréversible. Voulez-vous vraiment faire ça ?',yes:'Oui',no:'non'});

        $scope.$on('clickDialog',function(e,choice){
            Notify('close');
            if(choice.choice == "yes"){
                Projects.delete(id);
            
                // Delete from display
                for(var i in $scope.projects){
                    if($scope.projects[i].id==id){
                        $scope.projects.splice(i,1);
                    }
                }

                Notify('success','Projet supprimé','Le projet a été supprimé avec succès de votre liste ainsi que de tous les cahiers qui le contenaient.');
            }
        });
    };

    var ok = false;
    for (var i2 in categories.projects){
        if(categories.projects[i2].id==$scope.cat_id)
            ok=i2;
    }

    if(!ok){
        $location.path('projects/0');
        Notify('error',"Cette catégorie n'existe pas","La catégorie à laquelle vous tentez d'accéder n'existe pas");
        return false;
    }

    $scope.cat_name=categories.projects[ok].title;
    $scope.button_rename=false;
    $scope.toggleRenameInput=function(){
        $scope.button_rename=!$scope.button_rename;
        if($scope.button_rename===true)
            $scope.$broadcast('inputRenameShown');
    };

    $scope.changeCategoryName=function(e){
        if(e.which === 13 || e.type == "click" && $scope.cat_name !== ""){
            categories.projects[ok].title=$scope.cat_name;
            Categories.saveLocal(categories);
            $scope.toggleRenameInput();
        }
    };

}]);

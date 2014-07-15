App.controller('ProjectsCtrl', ['$scope','Projects','$routeParams', function ($scope,Projects,$routeParams) {
    $scope.projects = Projects.get($routeParams.project_id);
}]);

App.controller('AddProjectCtrl', ['$scope','Projects','$routeParams', function ($scope,Projects,$routeParams) {

    // Initial data
    $scope.project_data = {
        intro:"Introduction au projet",
        title:"Titre du projet",
        date:"date",
        desc:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci repellendus alias modi praesentium, delectus! Itaque odit ratione sit quisquam quia, cum quaerat ipsam mollitia vero deserunt. Asperiores atque nesciunt quidem."
    }

    if($routeParams.project_id!=undefined){
        $scope.project_data = Projects.get_by_id($routeParams.project_id);
    }

    $scope.projects = Projects.get();

    $scope.live_edit = {
        intro:false,
        name:false,
        date:false,
        desc:false
    }

    $scope.liveEdit = function(el,e){
        console.log($scope.project_data)
        if(el=='intro'){
            $scope.live_edit.intro=!$scope.live_edit.intro;
        }else if(el=='name'){
            $scope.live_edit.name=!$scope.live_edit.name;
        }else if(el=='date'){
            $scope.live_edit.date=!$scope.live_edit.date;
        }else if(el=='desc'){
            $scope.live_edit.desc=!$scope.live_edit.desc;
        }  
        $scope.$broadcast('live_edit_event.'+el);
    }
}]);
App.controller('ProjectsCtrl', ['$scope','Projects','$routeParams', function ($scope,Projects,$routeParams) {
    $scope.projects = Projects.get($routeParams.project_id);
}]);

App.controller('AddProjectCtrl', ['$scope','Projects','Categories','$routeParams', function ($scope,Projects,Categories,$routeParams) {

    utils.fixBottomBoxHeight();

    $scope.categories = Categories.get();
    $scope.projects = Projects.get(0);

    // Date
    var date=new Date()

    // Initial data
    $scope.project_data = {
        intro:"Introduction au projet",
        title:"Titre du projet",
        date:date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear(),
        desc:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci repellendus alias modi praesentium, delectus! Itaque odit ratione sit quisquam quia, cum quaerat ipsam mollitia vero deserunt. Asperiores atque nesciunt quidem.",
        tags:[],
        category:0
    }

    if($routeParams.project_id!=undefined){
        $scope.project_data = Projects.get_by_id($routeParams.project_id);
    }

    $scope.addProject=function(){ 

        var finalProject = $scope.project_data;
        var last_id=0;

        if(finalProject.id==null){
            // Create a project, so find a new ID
            for(var i in $scope.projects){
                last_id=$scope.projects[i].id;
            }
            finalProject.id=last_id+1;
            $scope.projects.push(finalProject);


        }else if($routeParams.project_id!=undefined){

            // Edit a projet, so edit an existing ID
            for(var i in $scope.projects){
                if($scope.projects[i].id==finalProject.id)
                    last_id=i;
            }
            $scope.projects[i]=finalProject;

        }

        Projects.saveLocal($scope.projects);
    }

    $scope.selectCategory=function(index){
        $scope.project_data.category=$scope.categories.projects[index].id;
    }

    // Tags
    $scope.addTag=function(e){
        if(e.which === 13 && $scope.addedTag != ""){ 
            $scope.project_data.tags.push($scope.addedTag);
            $scope.addedTag="";
        }
    };

    $scope.deleteTag=function(index){
        $scope.project_data.tags.splice(index,1);
        return false;
    };

}]);
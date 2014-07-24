App.controller('AddProjectCtrl', ['$scope','Projects','Categories','$routeParams','Notify','$location','NavigationService', function ($scope,Projects,Categories,$routeParams,Notify,$location,NavigationService) {

    utils.fixBottomBoxHeight();

    $scope.categories = Categories.get();
    $scope.projects = Projects.get(0);

    // Date
    var date=new Date();

    // Initial data
    $scope.project_data = {
        intro:"Introduction au projet",
        title:"Titre du projet",
        date:date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear(),
        desc:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci repellendus alias modi praesentium, delectus! Itaque odit ratione sit quisquam quia, cum quaerat ipsam mollitia vero deserunt. Asperiores atque nesciunt quidem.",
        tags:[],
        category:0,
        cover:"dist/img/sample.png",
        files:[]
    };

    // Files
    $scope.isUploading=false;

    $scope.uploadImg=function(){
        $scope.isUploading=true;
    };

    if($routeParams.project_id!==undefined){
        NavigationService.setPageTitle('Modifier un projet');
        $scope.project_data = Projects.getById($routeParams.project_id);

        if(typeof $scope.project_data == 'undefined'){
            $location.path('projects/0');
            Notify('error',"Ce projet n'existe pas","Le projet auquel vous tentez d'accéder n'existe pas");
            return false;
        }
    }else{
        NavigationService.setPageTitle('Ajouter un projet');
    }

    $scope.addProject=function(){ 

        var finalProject = $scope.project_data;

        // VALIDATION
        var validation = Projects.validate(finalProject);
        if(validation!==true){
            Notify('error',"Erreur lors de l'ajout",validation);
            return false;
        }

        var last_id=0;

        if(!(finalProject.hasOwnProperty('id'))){
            // Create a project, so find a new ID
            Projects.add(finalProject);
            Notify('success','Projet ajouté','Le projet a été ajouté avec succès');
        }else if($routeParams.project_id!==undefined){
            // Edit a projet, so edit an existing ID
            Projects.edit($routeParams.project_id,finalProject);
            Notify('success','Projet modifié','Le projet a été modifié avec succès');
        }

        $location.path( "/projects/0" );
    };

    $scope.selectCategory=function(index){
        $scope.project_data.category=$scope.categories.projects[index].id;
    };

    // Tags
    $scope.addTag=function(e){
        if(e.which === 13 && $scope.addedTag !== ""){ 
            $scope.project_data.tags.push($scope.addedTag);
            $scope.addedTag="";
        }
    };

    $scope.deleteTag=function(index){
        $scope.project_data.tags.splice(index,1);
        return false;
    };

    // Medias

    $scope.deleteMedia = function(index){
        $scope.project_data.files.splice(index,1);
    };

    $scope.uploadCoverComplete = function(content) {
        $scope.isUploading=false;
        if(content.status=="success"){
            $scope.project_data.cover="uploads/files/"+content.fileName;
        }else{
            Notify('error',"Erreur d'upload","Image de couverture refusée, verifiez la taille et l'extension de votre fichier.");
        }
    };

    $scope.uploadComplete = function(content) {
        $scope.isUploading=false;
        if(content.status=="success"){
            $scope.project_data.files.push({path:"uploads/files/"+content.fileName});
        }else{
            Notify('error',"Erreur d'upload","Upload refusé, verifiez la taille et l'extension de votre fichier.");
        }
    };

}]);
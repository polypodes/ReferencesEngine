
App.controller('AddBookCtrl', ['$scope','Projects','Themes','$http', function ($scope,Projects,Themes,$http) {

    $scope.pageTitle="Ajouter un cahier";

    // Fix width & heights
    utils.fixVScrollHeight();

    // Init projects
    var projects = Projects.get(0);
    for(var i in projects){
        projects[i].added=false;
    }

    // All projects
    $scope.projects = projects;
    // Projects added to the book
    $scope.projects_a = [];

    $scope.presentation_type = {
        my_projects : "block",
        all_projects : "block"
    }

    // Presentation 
    // ------------

    $scope.themes = Themes.get();

    $scope.changePresentation = function(type,projects){
        if(projects=="my_projects"){
            $scope.presentation_type.my_projects=type;
        }else if(projects=="all_projects"){
            $scope.presentation_type.all_projects=type;
        }
    }

    $scope.addToList = function(id){
        var i2=0;
        for(var i in $scope.projects){
            if(id==$scope.projects[i].id)
                i2=i;
        }

        if(!$scope.projects[i2].added){
            $scope.projects[i2].added=true;
            $scope.projects_a.push($scope.projects[i2]);
        }else{
            $scope.projects[i2].added=false;
            for(var i in $scope.projects_a){
                if($scope.projects_a[i].id==$scope.projects[i2].id)
                    $scope.projects_a.splice(i,1);
            }
        }
    }

    $scope.sortableOptions = {
        axis: 'y'
    };

    $scope.book = {
        cover:'',
        btitle:'Titre du cahier',
        subtitle:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, eum mollitia voluptatibus. Tempore impedit reprehenderit blanditiis praesentium ab, nemo nisi, quas eaque, voluptatem perferendis quidem, architecto exercitationem saepe facilis illo.',
        bottomline:'Pour [NOM DU CLIENT] fait le [DATE]',
        cover:'uploads/files/53c7c338ad51a.png',
        theme:$scope.themes[0]
    }; // Book infos
    $scope.couv_state = {}; // Couv state infos

    $scope.chooseTheme = function(id){
        $scope.book.theme=$scope.themes[id];
        $('link.template').attr('href',"src/templates/"+$scope.book.theme.src+".css")
    }
    $scope.chooseTheme(0);

    $scope.isUploading=false;
    $scope.uploadImg = function(){
        $scope.isUploading=true;
    }
    $scope.uploadCoverComplete = function(content) {
     $scope.isUploading=false;
        if(content.status=="success"){
            $scope.book.cover="uploads/files/"+content.fileName;
            console.log($scope.book.cover);
        }
    }


    $scope.openEditor = function(){
        var book = $scope.book;
        book.projects = $scope.projects_a;
        $scope.show_editor=true;
        console.log(book);
    }

    $scope.projects_a = $scope.projects;

}]);


App.controller('BooksCtrl', ['$scope','Books','navService','$routeParams', function ($scope,Books,navService,$routeParams) {
    $scope.books = Books.get($routeParams.book_id);
    Books.saveLocal($scope.books);
}]);

App.controller('AddBookCtrl', ['$scope','Projects','Themes','$http', function ($scope,Projects,Themes,$http) {

    $scope.pageTitle="Ajouter un cahier";

    // Fix width & heights
    utils.fixVScrollHeight();

    var projects = Projects.get(0);
    for(var i in projects){
        projects[i].added=false;
    }


    $scope.projects = projects;
    $scope.projects_a = [];

    $scope.presentation_type = {
        my_projects : "block",
        all_projects : "block"
    }

    $scope.themes = Themes.get();
    $scope.theme_a = {};

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

    $scope.openedSlide = "couv";
    $scope.openDetails = function(id){
        $scope.openedSlide=id;
    }

    $scope.sortableOptions = {
        axis: 'y'
    };

    $scope.book = {
        cover:'',
        btitle:'Titre du cahier',
        subtitle:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, eum mollitia voluptatibus. Tempore impedit reprehenderit blanditiis praesentium ab, nemo nisi, quas eaque, voluptatem perferendis quidem, architecto exercitationem saepe facilis illo.',
        bottomline:'Pour [NOM DU CLIENT] fait le [DATE]'
    }; // Book infos
    $scope.couv_state = {}; // Couv state infos

    $scope.chooseTheme = function(id){
        $scope.book.theme=$scope.themes[id]
    }

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

    // COVER EDITION
    $scope.bookInfoKeypress = function(){
        if($scope.book.btitle != undefined && $scope.book.image != undefined && $scope.book.btitle != "" && $scope.book.image != ""){
            if($scope.couv_state.a4!="coverEditor"){
                $scope.couv_state.a4="generated";
            }
            $scope.couv_state.pres="generated";
            $scope.couv_state.web="generated";
        }
    }

    $scope.previewBook = function(){
        var n_book = {
            book : {
                couv : $scope.book,
                couv_state : $scope.couv_state,
                theme : $scope.theme_a
            },
            slides : $scope.projects_a
        };

        $http({
            method  : 'POST',
            url     : 'templating/generate_json.php',
            data    : $.param({data:n_book}),  // pass in data as strings
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
        });
    }

    $scope.openEditor = function(){
        $scope.book.projects=$scope.projects_a;
        console.log($scope.book);
        console.log('saving');
        // $('link.template').attr('href','src/templates/'+$scope.book.theme.src+".css");
        // $scope.show_editor=true;
    }
}]);


App.controller('BooksCtrl', ['$scope','Books','navService','$routeParams', function ($scope,Books,navService,$routeParams) {
    $scope.books = Books.get($routeParams.book_id);
    Books.saveLocal($scope.books);
}]);
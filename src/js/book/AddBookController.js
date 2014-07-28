App.controller('AddBookCtrl', ['$scope','Projects','Themes','$http','Books','$routeParams','Notify','$location','Categories','NavigationService', function ($scope,Projects,Themes,$http,Books,$routeParams,Notify,$location,Categories,NavigationService){

    // Fix width & heights
    utils.fixVScrollHeight();

    // Init projects
    var projects = Projects.get(0);
    $scope.categories = Categories.get();

    // All projects
    $scope.projects = projects;
    $scope.projects_a = [];

    $scope.presentation_type = {
        my_projects : "block",
        all_projects : "block"
    };


    // Presentation 
    // ------------

    $scope.themes = Themes.get();

    $scope.changePresentation = function(type,projects){
        if(projects=="my_projects"){
            $scope.presentation_type.my_projects=type;
        }else if(projects=="all_projects"){
            $scope.presentation_type.all_projects=type;
        }
    };

    // Add and drag & drop
    // -------------------

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
            for(var i3 in $scope.projects_a){
                if($scope.projects_a[i3].id==$scope.projects[i2].id)
                    $scope.projects_a.splice(i3,1);
            }
        }
    };

    $scope.selectCategory=function(index){
        $scope.book.category=$scope.categories.books[index].id;
    };

    $scope.sortableOptions = {
        axis: 'y'
    };

    $scope.book = {
        btitle:'Titre du cahier',
        subtitle:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, eum mollitia voluptatibus. Tempore impedit reprehenderit blanditiis praesentium ab, nemo nisi, quas eaque, voluptatem perferendis quidem, architecto exercitationem saepe facilis illo.',
        bottomline:'Pour [NOM DU CLIENT] fait le [DATE]',
        cover:"dist/img/sample.png",
        date:'date',
        category:0,
        theme:$scope.themes[0],
        exported:false
    };

    // Test if exsits
    if($routeParams.book_id!==undefined){
        NavigationService.setPageTitle('Modifier un cahier');

        $scope.book = Books.getById($routeParams.book_id);
        $scope.projects_a=$scope.book.projects_a;

        if(typeof $scope.book == 'undefined'){
            $location.path('books/0');
            Notify('error',"Ce cahier n'existe pas","Le cahier auquel vous tentez d'accéder n'existe pas");
            return false;
        }
    }else{
        NavigationService.setPageTitle('Ajouter un cahier');
    }

    for(var i in projects){
        projects[i].added=false;
    }

    // Setting up added projects
    for(var i2 in $scope.projects_a){
        for(var j in $scope.projects){
            if($scope.projects_a[i2].id == $scope.projects[j].id)
                $scope.projects[j].added=true;
        }
    }

   

    $scope.chooseTheme = function(id){
        $scope.book.theme=$scope.themes[id];
    };

    $scope.chooseTheme(0);

    $scope.isUploading=false;
    $scope.uploadImg = function(){
        $scope.isUploading=true;
    };
    $scope.uploadCoverComplete = function(content) {
     $scope.isUploading=false;
        if(content.status=="success"){
            $scope.book.cover="uploads/files/"+content.fileName;
        }
    };

    $scope.saveBook = function(){
        var book = $scope.book;
        book.projects_a = $scope.projects_a;

        var validation = Books.validate(book);
        if(validation!==true){
            Notify('error',"Erreur lors de l'ajout",validation);
            return false;
        }        

        var id;

        if(!(book.hasOwnProperty('id'))){
            
            // Create new a book
            id = Books.add(book);
            Notify('success','Cahier ajouté','Le cahier a été ajouté à votre liste. Vous pouvez effectuer les derniers réglages via la prévisualisation.');

        }else if($routeParams.book_id!==undefined){

            // Edit a book
            id = book.id;
            Books.edit(id,book);
            Notify('success','Cahier modifié','Le cahier a été modifié avec succès. Vous pouvez effectuer les derniers réglages via la prévisualisation.');

        }
        
        $location.path('/book/'+id+'/edit');
    };

}]);
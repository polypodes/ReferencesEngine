App.controller('AddBookCtrl', ['$scope','Projects','Themes','$http','Books','$routeParams','Notify','$location','Categories', function ($scope,Projects,Themes,$http,Books,$routeParams,Notify,$location,Categories){

    $scope.pageTitle="Ajouter un cahier";

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
            for(var i in $scope.projects_a){
                if($scope.projects_a[i].id==$scope.projects[i2].id)
                    $scope.projects_a.splice(i,1);
            }
        }
    }

    $scope.selectCategory=function(index){
        $scope.book.category=$scope.categories.books[index].id;
    }

    $scope.sortableOptions = {
        axis: 'y'
    };

    // Sample data
    // -----------

    $scope.buttonLegend="Enregistrer le cahier";
    // Existing or new ? 
    if($routeParams.book_id!=undefined){
        $scope.book = Books.getById($routeParams.book_id);
        $scope.projects_a=$scope.book.projects_a;
        $scope.buttonLegend="Modifier le cahier";
    }else if($routeParams.book_id==null){
        $scope.book = {
            cover:'',
            btitle:'Titre du cahier',
            subtitle:'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, eum mollitia voluptatibus. Tempore impedit reprehenderit blanditiis praesentium ab, nemo nisi, quas eaque, voluptatem perferendis quidem, architecto exercitationem saepe facilis illo.',
            bottomline:'Pour [NOM DU CLIENT] fait le [DATE]',
            cover:"dist/img/sample.png",
            date:'date',
            category:0,
            theme:$scope.themes[0],
        };
    }


    for(var i in projects){
        projects[i].added=false;
    }

    // Setting up added projects
    for(var i in $scope.projects_a){
        for(var j in $scope.projects){
            if($scope.projects_a[i].id == $scope.projects[j].id)
                $scope.projects[j].added=true;
        }
    }

   

    $scope.chooseTheme = function(id){
        $scope.book.theme=$scope.themes[id];
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
        }
    }

    $scope.saveBook = function(){
        var book = $scope.book;

        var projects_a_ids = [];
        for(var i in $scope.projects_a){
            projects_a_ids.push($scope.projects_a[i].id);
        }
        book.projects_a = projects_a_ids;

        var validation = Books.validate(book);
        if(validation!=true){
            Notify('error',"Erreur lors de l'ajout",validation);
            return false;
        }        

        var last_id=0;

        if(book.id==null){

            // Create new a book
            var id = Books.add(book);
            Notify('success','Cahier ajouté','Le cahier a été ajouté à votre liste');

        }else if($routeParams.book_id!=undefined){

            // Edit a book
            var id = book.id;
            Books.edit(id,book);
            Notify('success','Cahier ajouté','Le cahier a été modifié avec succès');

        }
        
        Notify('success','Cahier ajouté','Le cahier a été ajouté à votre liste');
        $location.path('/book/'+id+'/edit');
    }

}]);

App.controller('BookEditorCtrl', ['$scope','Books','navService','$routeParams','Notify', function ($scope,Books,navService,$routeParams,Notify) {
    $scope.book = Books.getById($routeParams.book_id);
    $('link.template').attr('href',"src/templates/"+$scope.book.theme.src+".css");
}]);

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
App.controller('NavCtrl', ['$scope','$location','Categories', function ($scope,$location,Categories) {
	$scope.pageTitle="";

    $scope.mainItems = [
		{path: '/overview', title: "Vue d'ensemble", icon:"fa-tachometer"},
		{path: '/settings', title: 'Réglages', icon:"fa-cog"}
    ];

    $scope.addItems = [
		{path: '/add_project', title: "Ajouter un projet"},
		{path: '/add_book', title: 'Ajouter un cahier'}
    ];

    $scope.categoriesItems = Categories.get();

    // Add "all" links

    Categories.saveLocal($scope.categoriesItems);

	$scope.isActive = function(item) {
		if (item.path == $location.path()) {
			$scope.pageTitle=item.title;
			return true;
		}
		return false;
	};

	// $scope.$on('$locationChangeStart', function(next, current) { 
	//    // ngProgress.start();
	//  });

	// $scope.$on('$locationChangeSuccess', function(next, current) {
	//    	// ngProgress.complete();
	//  });

	$scope.inputCategory={
		project:"",
		book:""
	}
	// Events
	$scope.addProjectCategory=function(e){
		if(e.which === 13 || e.type == "click" && $scope.inputCategory.project != ""){
			var last_id=0;
			for(var i in $scope.categoriesItems.projects){
				if(typeof($scope.categoriesItems.projects[i])!='function')
					last_id=$scope.categoriesItems.projects[i].id;
			}
			$scope.categoriesItems.projects.push({id:(parseInt(last_id)+1),title:$scope.inputCategory.project,path:'/projects/'+(parseInt(last_id)+1)});
			$scope.inputCategory.project="";

			Categories.saveLocal($scope.categoriesItems);
		}
	};

	$scope.addBookCategory=function(e){
		if(e.which === 13 || e.type == "click" && $scope.inputCategory.book != ""){
			var last_id=0;
			for(var i in $scope.categoriesItems.books){
				if(typeof($scope.categoriesItems.books[i])!='function')
					last_id=$scope.categoriesItems.books[i].id;
			}
			$scope.categoriesItems.books.push({id:(parseInt(last_id)+1),title:$scope.inputCategory.book,path:'/books/'+(parseInt(last_id)+1)});
			$scope.inputCategory.book="";

			Categories.saveLocal($scope.categoriesItems);
		}
	};

	$scope.deleteCategory=function(t,i){
		if(t=='projects'){
			$scope.categoriesItems.projects.splice(i,1);
		}else if(t=='books'){
			$scope.categoriesItems.books.splice(i,1);
		}
		Categories.saveLocal($scope.categoriesItems);
	};

}]);
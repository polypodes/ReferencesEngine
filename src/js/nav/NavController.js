App.controller('NavCtrl', ['$scope','$location','Categories','Notify','instantHelp','$rootScope','NavigationService', function ($scope,$location,Categories,Notify,instantHelp,$rootScope,NavigationService) {

	node_win.showDevTools();

	// SHORTCUTS
	$(document).on('keyup',function(e){
		if(e.keyCode == 'N'.charCodeAt(0) && e.ctrlKey && e.shiftKey) {
		    $location.path('add_book');
		    $scope.$apply();
		}else if(e.keyCode == 'N'.charCodeAt(0) && e.ctrlKey) {
		    $location.path('add_project');
		    $scope.$apply();
		}
	})

	// TOP MENU
	// Create an empty menu
	var gui = node_gui;
	var mb = new gui.Menu({type:"menubar"});
	mb.createMacBuiltin("Refaktor");
	gui.Window.get().menu = mb;

	
	$scope.topButton = function(type){
		console.log(type);
		if(type=='red'){
			node_win.close();
		}else if(type=='orange'){
			node_win.minimize();
		}else if(type=='green'){
			node_win.enterFullscreen();
		}
	}
	$scope.instantHelp = function(){
		instantHelp('page');
	};

    $scope.mainItems = [
		{path: '/overview', title: "Vue d'ensemble", icon:"fa-tachometer"},
		{path: '/settings', title: 'Réglages', icon:"fa-cog"}
    ];

    $scope.addItems = [
		{path: '/add_project', title: "Ajouter un projet"},
		{path: '/add_book', title: 'Ajouter un cahier'}
    ];

    $scope.preBooksItems = [
		{path: '/books/exported', title: "Exporter / Présenter"}
    ];

    $scope.categoriesItems = Categories.get();

	$scope.isActive = function(item) {
		if (item.path == $location.path()) {
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
	};
	// Events
	$scope.addProjectCategory=function(e){
		if(e.which === 13 || e.type == "click" && $scope.inputCategory.project !== ""){
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
		if(e.which === 13 || e.type == "click" && $scope.inputCategory.book !== ""){
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

	$scope.deleteCategory=function(t,i,ind){
		Categories.delete(t,i);
		// remove from display

		// check if user is on the page
		var inC = false;

		if(t=='projects'){
			if ($scope.categoriesItems.projects[ind].path == $location.path())
				inC = true;

			$scope.categoriesItems.projects.splice(ind,1);

			if(inC)
				$location.path('projects/0');

		}else if(t=='books'){
			if ($scope.categoriesItems.books[ind].path == $location.path())
				inC = true;

			$scope.categoriesItems.books.splice(ind,1);

			if(inC)
				$location.path('books/0');

		}

	
		
		
	};

	var rc=0;
	$scope.goBack=function(){
		window.history.back();
		rc-=2;
	};

	$scope.$on('$routeChangeSuccess', function(next, current) {
		Notify('close');
		if(rc>=1){
			$scope.isPrev=true;	
		}else{
			$scope.isPrev=false;	
		}
		rc++;
	});

}]);
App.controller('InstallCtrl', ['$scope','$rootScope','$location','NavigationService','Install', function ($scope,$rootScope,$location,NavigationService,Install) {

	$scope.isSlideActive=[];
	$scope.isSlideActive[0]="active";
	$scope.isSlideActive[1]="";
	$scope.isSlideActive[2]="";
	$scope.activeNb="first_active";

	$scope.goToPage = function(id){
		if(id=="end"){
			$rootScope.$broadcast('refreshCategories');
			window.location.href = "index.html#/overview/";
		}

		for(var j in $scope.isSlideActive)
			$scope.isSlideActive[j]="";

		$scope.isSlideActive[id]="active";

		// if(id==0){$scope.activeNb="first_active";}
		// else if(id==1){$scope.activeNb="second_active";}
		// else if(id==2){$scope.activeNb="third_active";}
	}

    NavigationService.setPageTitle('Installation');
    Install.installApp();

}]);
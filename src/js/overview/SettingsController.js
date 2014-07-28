App.controller('SettingsCtrl', ['$scope','NavigationService','Settings','Notify', function ($scope,NavigationService,Settings,Notify) {
    NavigationService.setPageTitle('Mes réglages');

   	$scope.settings = Settings.get();

   	$scope.saveSettings = function(){
   		Settings.save($scope.settings);
        Notify('success','Réglages modifiés','Les réglages ont été modifiés avec succès');
   	}


}]);
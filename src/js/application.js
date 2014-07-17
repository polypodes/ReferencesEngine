var utils = new utilsClass();

// Backoffice app
var App = angular.module('App', ['ngRoute','ui.sortable','LocalStorageModule','ngUpload','ngAnimate'])
.config(['localStorageServiceProvider', function(localStorageServiceProvider){
  localStorageServiceProvider.setPrefix('_rfktor');
}]);

App.run(['$rootScope', function($rootScope){
    $rootScope.notify = {
    	state:"closed",
    	title:"title",
    	message:"message"
    };
}]);
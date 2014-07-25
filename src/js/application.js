var utils = new utilsClass();

// Backoffice app
var App = angular.module('App', ['gridster','ngRoute','ui.sortable','LocalStorageModule','ngUpload','ngAnimate','ngCookies'])
.config(['localStorageServiceProvider', function(localStorageServiceProvider){
  localStorageServiceProvider.setPrefix('_rfktor');
}]);

// Notification init
App.run(['$rootScope', function($rootScope){
    $rootScope.notify = {
    	state:"closed",
    	title:"title",
    	message:"message"
    };
}]);
var utils = new utilsClass();

// Backoffice app
var App = angular.module('App', ['ngRoute','ui.sortable','LocalStorageModule'])
.config(['localStorageServiceProvider', function(localStorageServiceProvider){
  localStorageServiceProvider.setPrefix('_rfktor');
}]);

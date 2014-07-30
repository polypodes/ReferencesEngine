var utils = new utilsClass();

function setStorage(i,table){
	if(typeof table=="undefined"){
		table=Math.floor(Math.random()*(99*99));}
	var t = [];
	for(var j=0;j<=i*1024;j++){
		t.push(Math.floor(Math.random()*(99*99)));}
	localStorage.setItem(table,t);
	console.log('elements created');
}

function getStorageSize(){
	var t=0;for(var x in localStorage){console.log(x+"="+((localStorage[x].length * 2)/1024/1024).toFixed(2)+" MB");t+=((localStorage[x].length * 2)/1024/1024);};console.log("TOTAL:"+t.toFixed(2));
}

// Backoffice app
var App = angular.module('App', ['gridster','ngRoute','ui.sortable','LocalStorageModule','ngUpload','ngAnimate','ngCookies']);
var presentApp = angular.module('presentApp', ['ngRoute','ngAnimate']);

// Notification init
App.run(['$rootScope', function($rootScope){
    $rootScope.notify = {
    	state:"closed",
    	title:"title",
    	message:"message"
    };
}]);
App.controller('OverviewCtrl', ['$scope','Projects','Stats','NavigationService', function ($scope,Projects,Stats,NavigationService) {
    
    NavigationService.setPageTitle("Vue d'ensemble");
    $scope.pageTitle="Vue d'ensemble";
       
       // Stats for dashboard
    $scope.stats = Stats.getForDashboard();

	// Top left graph
    $('canvas#consultations').attr('width',$('.top .graph').width()-40);

    var ctx = document.getElementById("consultations").getContext("2d");

    var data = {
	    labels: $scope.stats.views.timeline.labels,
	    datasets: [
	        {
	            label: "Consultations",
	            fillColor: "rgba(101,208,186,0.15)",
	            strokeColor: "rgba(101,208,186,1)",
	            pointColor: "rgba(46,179,152,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(220,220,220,1)",
	            data: $scope.stats.views.timeline.data
	        }
	    ]
	};

	var options = {
	    pointHitDetectionRadius : 10,
	    responsive:true
	};

    var myLineChart = new Chart(ctx).Line(data, options);


}]);
App.controller('OverviewCtrl', ['$scope','Projects','Stats', function ($scope,Projects,Stats) {
    
    $scope.pageTitle="Vue d'ensemble";
       
       // Stats for dashboard
    $scope.stats = Stats.getForDashboard();
    console.log($scope.stats);

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
	    scaleShowGridLines : true,
	    scaleGridLineColor : "rgba(0,0,0,.05)",
	    scaleGridLineWidth : 1,
	    bezierCurve : true,
	    bezierCurveTension : 0.4,
	    pointDot : true,
	    pointDotRadius : 4,
	    pointDotStrokeWidth : 1,
	    pointHitDetectionRadius : 30,
	    showTooltips: false,
	    responsive:true,
	    datasetStroke : false,
	    datasetStrokeWidth : 2,
	    datasetFill : true
	};

    var myLineChart = new Chart(ctx).Line(data, options);


}]);
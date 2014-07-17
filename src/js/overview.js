App.controller('OverviewCtrl', ['$scope','Projects', function ($scope,Projects) {
    
    $scope.pageTitle="Vue d'ensemble";

    // DATES GENERATING
    var to = new Date();
	var from = new Date();
	from.setDate(from.getDate() - 14);

	var day;
	var dates = [];
	var dates_values = [];

	while(from <= to) {
	    day = to.getDate()
	    to = new Date(to.setDate(--day));
	    var date = to.getDate()+'/'+(to.getMonth()+1)+'/'+to.getFullYear();
	    dates.push(date);

	    var val = Math.floor(Math.random()*201);
	    dates_values.push(val);
	}

    $('canvas#consultations').attr('width',$('.top .graph').width()-40);

    var ctx = document.getElementById("consultations").getContext("2d");

    var data = {
	    labels: dates,
	    datasets: [
	        {
	            label: "Consultations",
	            fillColor: "rgba(101,208,186,0.15)",
	            strokeColor: "rgba(101,208,186,1)",
	            pointColor: "rgba(46,179,152,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(220,220,220,1)",
	            data: dates_values
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
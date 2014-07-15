App.controller('OverviewCtrl', ['$scope','Projects', function ($scope,Projects) {
    
    $scope.pageTitle="Vue d'ensemble";

    $('canvas#consultations').attr('width',$('.top .graph').width()-40);

    var ctx = document.getElementById("consultations").getContext("2d");

    var data = {
	    labels: ["08/07", "09/07", "10/07", "11/07", "12/07", "13/07", "14/07", "15/07"],
	    datasets: [
	        {
	            label: "Consultations",
	            fillColor: "rgba(101,208,186,0.15)",
	            strokeColor: "rgba(101,208,186,1)",
	            pointColor: "rgba(46,179,152,1)",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fff",
	            pointHighlightStroke: "rgba(220,220,220,1)",
	            data: [30, 65, 59, 80, 81, 56, 55, 40]
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
	    pointHitDetectionRadius : 20,
	    datasetStroke : true,
	    datasetStrokeWidth : 2,
	    datasetFill : true,
	    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

	};

    var myLineChart = new Chart(ctx).Line(data, options);


}]);
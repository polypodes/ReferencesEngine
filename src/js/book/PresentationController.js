presentApp.controller('PresentationCtrl', ['$scope','$routeParams','Presentation', function ($scope,$routeParams,Presentation) {

	if($routeParams.book_id!==undefined){
		// node_win.enterKioskMode();
        var initial_book = Presentation.getBook($routeParams.book_id);

        // REORGANIZE BOOK, transform in a pages book
        var book = [{
        	type:'cover',
        	bottomline:initial_book.bottomline,
        	btitle:initial_book.btitle,
        	category:initial_book.category,
        	cover:initial_book.cover,
        	date:initial_book.date,
        	id:initial_book.id,
        	exported:initial_book.exported,
        	subtitle:initial_book.subtitle,
        	theme:initial_book.theme
        }];

        for(var i in initial_book.projects_a){

        	var item = initial_book.projects_a[i];
        	item.type='project';
        	book.push(item);

        	if(initial_book.projects_a[i].files.length!=0)
        		book.push({
        			type:'medias',
        			title:initial_book.projects_a[i].title,
        			id:initial_book.projects_a[i].id,
        			files:initial_book.projects_a[i].files
        		});
        }

        console.log(book);
        $scope.book=book;

        // Init variables
        $scope.activePage=1;
        $scope.showFiles=false;
        $('#themestyle').attr('href','src/templates/'+initial_book.theme.src+'/style.css');

        // Go back and go next in slides
        $scope.goBack = function(){
            if(($scope.activePage-1)>=0){
                $scope.activePage--;
                $scope.$apply();
            }
        };
        $scope.goNext = function(){
            if($scope.activePage<$scope.book.length-1){
                $scope.activePage++;
                $scope.$apply();
            }
        };

        // Init events
        var isKeyUp=false,
        	isKeyUpTimer;
        $('html').on('keyup',function(e){

			isKeyUp=true;
        	clearTimeout(isKeyUpTimer);
        	isKeyUpTimer=setTimeout(function(){
        		isKeyUp=false;
        	},200);

        	switch(e.which) {
		        case 37: // left
		        	$scope.goBack();
		        break;

		        case 39: // right
		        	$scope.goNext();
		        break;

		        default: return; // exit this handler for other keys
		    }

		    e.preventDefault(); // prevent the default action (scroll / move caret)
        });

        var topBarTimer;

        $scope.topBarClass="hidden";
        $(document).on('mousemove',function(e){

        	if(!isKeyUp){
	        	$scope.topBarClass="";
	        	$scope.$apply();

	        	clearTimeout(topBarTimer);
	        	topBarTimer=setTimeout(function(){
	        		$scope.topBarClass="hidden";
	        		$scope.$apply();
	        	},1000);
	        }
        	
        });


        // Topbar events

        $scope.goEditor = function(){
            window.location.href = "index.html#/book/"+$routeParams.book_id+"/edit";
        };
        $scope.toggleFullscreen = function(){
            node_win.toggleKioskMode();
        };
        
    }
}]);

App.directive('focusOn', function() {
   return function(scope, elem, attr) {
      scope.$on(attr.focusOn, function(e) {
            setTimeout(function(){
                elem[0].focus();
            },1);
      });
   };
});


// File upload
App.directive('file', function() {
    return {
        require:"ngModel",
        restrict: 'A',
        link: function($scope, el, attrs, ngModel){
            el.bind('change', function(event){
                $('input.fileSubmit').trigger('click');
                $scope.$apply();
            });
        }
    };
});
App.directive('cover', function() {
    return {
        require:"ngModel",
        restrict: 'A',
        link: function($scope, el, attrs, ngModel){
            el.bind('change', function(event){
                $('input.fileSubmitCover').trigger('click');
                $scope.$apply();
            });
        }
    };
});

// Background image
App.directive('backImg', function(){
    return function(scope, element, attrs){
        var url = attrs.backImg;
        element.css({
            'background-image': 'url(' + url +')',
            'background-size' : 'cover'
        });
    };
});

// Notifications
App.factory('Notify',['$rootScope','$timeout', function($rootScope,$timeout) {
    
    $rootScope.notify.state="closed";
    
    var timeout;
    function initTimeout(){ 
        $timeout.cancel(timeout);
        timeout = $timeout(function(){
            $rootScope.notify.state="closed";
        },2500);
    }

    var msgs = [];
    $rootScope.notify="opened";

    return function(type,title,msg) {
        if(type=='close'){
            if($rootScope.notify.type=="question"){
                $rootScope.notify.state="closed";
            }
        }else{ 

            $rootScope.dialogClick = function(choice){
                $rootScope.$broadcast('clickDialog',{choice:choice});
            };

            $rootScope.notify={
                state:"opened",
                type:type,
                title:title,
                msg:msg
            };

            if(type!='question'){
                initTimeout();

                $('.info-box').hover(
                    function(){
                        $timeout.cancel(timeout);
                    },
                    function(){
                        initTimeout();
                    }
                );
            }
        }

    };
}]);

// // medias placement
// App.directive('mediasTable', function() {
//     // return function(scope, elem, attr) {
//     //     var h = 500;
//     //     var cell_h = h/4;

//     //     for(var i=0;i<4;i++){
//     //         for(var j=0;j<4;j++)
//     //             $(elem[0]).append('<div class="cell" style="position:absolute;top:'+i*cell_h+'px;left:'+j*25+'%;width:25%;height:'+cell_h+'px;display:block;border:1px solid grey; z-index:2;"></div>');
//     //     }
//     // };
// });

// App.directive('mediaCell', function() {
//     return function(scope, elem, attr){
//         scope.$watch(
//             function(){
//                 var h = 500;
//                 var cell_h = h/4;

//                 $(elem[0]).css({
//                     height:cell_h*attr.mediaH+"px",
//                     width:25*attr.mediaW+"%",
//                     top:cell_h*(attr.mediaY)+"px",
//                     left:25*(attr.mediaX)+"%"
//                 })
//                 console.log('drawed');
//             }
//         );

//         // Move element
//         var i, $this;
//         $(elem[0]).on({
//             // on commence le drag
//             dragstart: function(e) {
//                 $this = $(this);
//             },
//             dragend: function(e) {
//                 // COL
//                 var x = (e.originalEvent.offsetX/$('.images .image').width())
//                 var col=0;

//                 if(x>0.3 && x<1.5){
//                     col=1;
//                 }else if(x<-0.3 && x>-1.5){
//                     col=-1
//                 }else if(x<-1.5 && x>-2.5){
//                     col=-2;
//                 }else if(x>1.5 && x<2.5){
//                     col=2;
//                 }else if(x>2.5){
//                     col=3;
//                 }else if(x<-2.5){
//                     col=-3;
//                 }

//                 // ROW
//                 var y = ((e.originalEvent.offsetY-$('.images .image').height())/$('.images .image').height());
//                 var row=0;
                
//                 if(y>0.3 && y<1.5){
//                     row=1;
//                 }else if(y<-0.3 && y>-1.5){
//                     row=-1
//                 }else if(y<-1.5 && y>-2.5){
//                     row=-2;
//                 }else if(y>1.5 && y<2.5){
//                     row=2;
//                 }else if(y>2.5){
//                     row=3;
//                 }else if(y<-2.5){
//                     row=-3;
//                 }

//                 $(elem[0]).css('z-index',200);
//                 scope.image.col+=col;
//                 scope.image.row+=row;
//                 scope.$apply();
//             }
//         });
//     };
// });
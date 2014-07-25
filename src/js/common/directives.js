
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

App.factory('instantHelp', function() {
    return function() {
        $('#helpme').joyride('destroy');
        $("#helpme").joyride({
            'tipLocation': 'top'
        });
        $("#helpme").joyride();
    };
});

App.factory('NavigationService', ['$rootScope', function($rootScope) {
    $rootScope.pageInfos={};
    return {
        setPageTitle: function(t) {
            $rootScope.pageInfos.pageTitle=t;
        }
    };
}]);

App.directive('focusOn', function() {
   return function(scope, elem, attr) {
      scope.$on(attr.focusOn, function(e) {
            setTimeout(function(){
                elem[0].focus();
            },1)
            
      });
   };
});

App.directive('itemAnimation', function() {
   return function(scope, elem, attr) {
        // if(scope.$first){
        //     elem.parent().append('<div class="loading">Chargement des éléments ...</div>');
        // }
        if(scope.$last){
            
            $(".items .item").each(function(i,el){
                // if(i==1)
                //     elem.parent().find('.loading').fadeOut();

                setTimeout(function(){
                    $(el).addClass('visible');
                },i*50)
            });
        }
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
});​

App.factory('Notify',['$rootScope','$timeout', function($rootScope,$timeout) {
    var msgs = [];
    $rootScope.notify="opened";
    return function(type,title,msg) {

        $rootScope.notify={
            state:"opened",
            type:type,
            title:title,
            msg:msg
        };

        var timeout;
        function initTimeout(){
            $timeout.cancel(timeout);
            timeout = $timeout(function(){
                $rootScope.notify.state="closed";
            },2500);
        }
        initTimeout();

        $('.info-box').hover(
            function(){
                $timeout.cancel(timeout);
            },
            function(){
                initTimeout();
            });

    };
  }]);
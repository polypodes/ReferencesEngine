App.directive('focusOn', function() {
   return function(scope, elem, attr) {
      scope.$on(attr.focusOn, function(e) {
            setTimeout(function(){
                elem[0].focus();
            },1)
            
      });
   };
});
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
App.factory('Settings', ['dataStorageService', function (dataStorageService) {

    function checkExisting(data){
        if(data===null){
            dataStorageService.set('settings',{});
        }
    }

    return {
        get: function() {
            var settings = dataStorageService.get('settings');
            return settings;
        },
        save : function(data){
            dataStorageService.set('settings',data);
        }
    };
}]);
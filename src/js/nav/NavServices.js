App.factory('navService', function() {  
    var active = 'overview';

    return {
        getProperty: function () {
            return active;
        },
        setProperty: function(value) {
            active = value;
        }
    };
});

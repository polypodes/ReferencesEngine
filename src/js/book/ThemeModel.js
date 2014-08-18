App.factory('Themes', ['dataStorageService', function (dataStorageService) {

    function createSampleData(){
        dataStorageService.set('themes',[{id:0,title:"MediumStyle",src:"theme1",files:['main.js','jquery']}]);
    }

    return {
        get: function() {
            var themes = dataStorageService.get('themes');
            if(themes.length==0){
                createSampleData();
                console.log('creating')
            }
            return themes;
        },
        save : function(data){
            dataStorageService.set('themes',data);
        }
    };
}]);
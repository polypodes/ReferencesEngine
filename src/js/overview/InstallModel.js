App.factory('Install', ['dataStorageService', function (dataStorageService) {
    return {
        installApp: function(){
            var cats = {
                projects:[
                    {id:0,title:"Tous les projets",path:"/projects/"}
                ],
                books:[
                    {id:0,title:"Tous les cahiers",path:"/books/"}
                ]
            };

            dataStorageService.set('books',[]);
            dataStorageService.set('categories',cats);
            dataStorageService.set('projects',[]);
            dataStorageService.set('settings',[]);
            dataStorageService.set('themes',[{id:0,title:"MediumStyle",src:"theme1",files:['main.js','jquery']}]);
        }
    };
}]);
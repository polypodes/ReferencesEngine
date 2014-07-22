
App.factory('Categories',['localStorageService', function (localStorageService) {
    
    var cats = localStorageService.get('categories');

    return {
        get: function(){
            for(var i in cats){
                for(var j in cats[i]){
                    if(cats[i][j].id!==null)
                        cats[i][j].path='/'+i+'/'+cats[i][j].id;
                }
            }

            if(cats===null){
                cats = {
                    projects:[
                        {id:0,title:"Tous les projets",path:"/projects/"}
                    ],
                    books:[
                        {id:0,title:"Tous les cahiers",path:"/books/"}
                    ]
                };
            }
            return cats;
        },
        saveLocal : function(data){
            localStorageService.set('categories',data);
        }
    };
}]);
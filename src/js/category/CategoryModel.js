
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
        },
        delete : function(t,i){
            i=parseInt(i);

            var cats = localStorageService.get('categories');

            /* jshint ignore:start */
            if(t=='projects'){

                for(var k in cats.projects){
                    if(cats.projects[k].id==i)
                        cats.projects.splice(k,1);
                }

                // replace all projects to "all"
                var projects = localStorageService.get('projects');
                for(var j in projects){
                    if(projects[j].category == i){
                        projects[j].category=0;
                    }
                }
                localStorageService.set('projects',projects);

            }else if(t=='books'){

                for(var k in cats.books){
                    if(cats.books[k].id==i)
                        cats.books.splice(k,1);
                }

                // replace all books to "all"
                var books = localStorageService.get('books');
                for(var j in books){
                    if(books[j].category == i){
                        books[j].category=0;
                    }
                }
                localStorageService.set('books',books);

            }
            /* jshint ignore:end */
            
            localStorageService.set('categories',cats);

        }
    };
}]);
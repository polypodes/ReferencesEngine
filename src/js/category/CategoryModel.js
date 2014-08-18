
App.factory('Categories',['dataStorageService', function (dataStorageService) {

    return {
        checkIfFirstLaunch: function(){
            var filename="_datacategories.json";
            var path = dataPath+"/"+filename;

            if(node_fs.existsSync(path)){
                return false;
            }else{
                return true;
            }
        },
        get: function(){
            var cats = dataStorageService.get('categories');

            for(var i in cats){
                for(var j in cats[i]){
                    if(cats[i][j].id!==null)
                        cats[i][j].path='/'+i+'/'+cats[i][j].id;
                }
            }

            return cats;
        },
        saveLocal : function(data){
            console.log('SAVELOCAL');
            console.log(data);
            dataStorageService.set('categories',data);
        },
        delete : function(t,i){
            i=parseInt(i);

            var cats = dataStorageService.get('categories');

            /* jshint ignore:start */
            if(t=='projects'){

                for(var k in cats.projects){
                    if(cats.projects[k].id==i)
                        cats.projects.splice(k,1);
                }

                // replace all projects to "all"
                var projects = dataStorageService.get('projects');
                for(var j in projects){
                    if(projects[j].category == i){
                        projects[j].category=0;
                    }
                }
                dataStorageService.set('projects',projects);

            }else if(t=='books'){

                for(var k in cats.books){
                    if(cats.books[k].id==i)
                        cats.books.splice(k,1);
                }

                // replace all books to "all"
                var books = dataStorageService.get('books');
                for(var j in books){
                    if(books[j].category == i){
                        books[j].category=0;
                    }
                }
                dataStorageService.set('books',books);

            }
            /* jshint ignore:end */
            
            dataStorageService.set('categories',cats);

        }
    };
}]);
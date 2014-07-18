App.factory('Projects',['localStorageService', function (localStorageService) {

    function checkExisting(data){
        if(data==null){
            localStorageService.set('projects',[]);
        }
    }

    return {
        get: function(id) {
            var projects = localStorageService.get('projects');
            checkExisting(projects);

            if(id!=0){
                var temp_projects=[];
                for(var i in projects){
                    if(projects[i].category==id){
                        temp_projects.push(projects[i]);
                    }
                }
            }else{
                temp_projects=projects;
            }

            return temp_projects;
        },
        getById : function(id) {
            var projects = localStorageService.get('projects');
            checkExisting(projects);
            for(var i in projects){
                if(projects[i].id==id){
                    return projects[i];
                }
            }
        },
        saveLocal : function(data){
            localStorageService.set('projects',data);
            console.log('saved projects to localstorage')
        },
        add : function(data){
            var projects = localStorageService.get('projects');

            var last_id=0;

            for(var i in projects){
                last_id=projects[i].id;
            }
            data.id=last_id+1;

            console.log(data.id);
            projects.push(data);

            console.log(projects);

            localStorageService.set('projects',projects);

            return data.id;
        },
        edit : function(id,data){
            var projects = localStorageService.get('projects');

            for(var i in projects){
                if(projects[i].id==id)
                    last_id=i;
            }

            projects[last_id]=data;
            localStorageService.set('projects',projects);
        }
    };
}]);


App.factory('Books', ['localStorageService', function (localStorageService) {

    function checkExisting(data){
        if(data==null){
            localStorageService.set('books',[]);
        }
    }

    return {
        get: function(id) {
            var books = localStorageService.get('books');
            checkExisting(books);
            if(id!=0){
                var temp_books=[];
                for(var i in books){
                    if(books[i].category==id){
                        temp_books.push(books[i]);
                    }
                }
            }else{
                temp_books=books;
            }

            return temp_books;
        },
        getById : function(id) {
            var books = localStorageService.get('books');
            var projects = localStorageService.get('projects');

            checkExisting(books);

            var book={};

            // Find the book
            for(var i in books){
                if(books[i].id==id){
                    book = books[i];
                }
            }

            var projects_a_temp=[];

            var perf=0;
            // Add the projects
            for(var i2 in book.projects_a){
                // Project to add id
                var pid = book.projects_a[i2];
                // Project to add content
                for(var i3 in projects){
                    if(projects[i3].id==pid)
                        projects_a_temp.push(projects[i3]);

                    perf++;
                }
            }

            console.log(perf);
            book.projects_a=projects_a_temp;

            return book;
        },
        saveLocal : function(data){
            localStorageService.set('books',data);
            console.log('saved books to localstorage')
        },
        add : function(data){
            var books = localStorageService.get('books');

            var last_id=0;

            for(var i in books){
                last_id=books[i].id;
            }
            data.id=last_id+1;

            books.push(data);
            localStorageService.set('books',books);

            return data.id;
        },
        edit : function(id,data){
            var books = localStorageService.get('books');

            for(var i in books){
                if(books[i].id==id)
                    last_id=i;
            }

            books[last_id]=data;
            localStorageService.set('books',books);
        }
    };
}]);

App.factory('Categories',['localStorageService', function (localStorageService) {
    
    var cats = localStorageService.get('categories');

    return {
        get: function(){
            for(var i in cats){
                for(var j in cats[i]){
                    if(cats[i][j].id!=null)
                        cats[i][j].path='/'+i+'/'+cats[i][j].id;
                }
            }

            if(cats==null){
                cats = {
                    projects:[
                        {id:0,title:"Tous les projets",path:"/projects/"}
                    ],
                    books:[
                        {id:0,title:"Tous les cahiers",path:"/books/"}
                    ]
                }
            }
            return cats;
        },
        saveLocal : function(data){
            localStorageService.set('categories',data);
        }
    };
}]);

App.factory('Themes', function () {
  return {
    get: function() {
        var themes = [
            {id:0,title:"Theme 1",src:"theme1"},
            {id:1,title:"Theme 2",src:"theme2"},
            {id:2,title:"Theme 3",src:"theme3"},
            {id:3,title:"Theme 4",src:"theme4"},
        ];
        return themes;
    }
  };
});

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

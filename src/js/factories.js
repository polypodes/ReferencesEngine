App.factory('Projects',['localStorageService', function (localStorageService) {

    // var desc = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam nulla labore ea placeat accusamus, quae quasi tenetur neque, a nostrum consectetur illo corporis fuga odit, amet. Aut nam deserunt qui?"
    // var projects = [
    //     {id:0,intro:"Projet web",title:"Le Grand Débat",date:"Juillet 2014",books_count:"1",desc:desc,tags:['webdesign','css','nantes','open-source'],category:1},
    //     {id:1,intro:"Projet web",title:"Auran",date:"Juillet 2014",books_count:"1",desc:desc,tags:['open-source'],category:1},
    //     {id:2,intro:"Projet web",title:"Bagybag",date:"Juillet 2014",books_count:"1",desc:desc,tags:['css','nantes','open-source'],category:2},
    //     {id:3,intro:"Projet web",title:"NFI",date:"Juillet 2014",books_count:"5",desc:desc,tags:['webdesign','html','css','nantes','open-source'],category:2},
    //     {id:4,intro:"Projet web",title:"NFI refonte",date:"Juin 2014",books_count:"5",desc:desc,tags:['webdesign','html','open-source'],category:1},
    //     {id:5,intro:"Print",title:"Brochure Magasin",date:"Juillet 2014",books_count:"1",desc:desc,tags:['webdesign','css','nantes','open-source'],category:0},
    //     {id:6,intro:"Projet web",title:"Rénovation intranet",date:"Juillet 2014",books_count:"1",desc:desc,tags:['open-source'],category:1},
    //     {id:7,intro:"Projet web",title:"Site e-cigarette",date:"Juillet 2014",books_count:"1",desc:desc,tags:['css','nantes','open-source'],category:0}
    // ]; 

    var projects = localStorageService.get('projects');

    return {
        get: function(id) {
            console.log(id)
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
        get_by_id : function(id) {
            for(var i in projects){
                if(projects[i].id==id){
                    return projects[i];
                }
            }
        },
        saveLocal : function(data){
            localStorageService.set('projects',data);
            console.log('saved projects to localstorage')
        }
    };
}]);


App.factory('Books', ['localStorageService', function (localStorageService) {

    // var books = [
    //     {id:0,title:"Références e-commerce",date:"Juillet 2014",category:0},
    //     {id:1,title:"Nantes métropole",date:"Juillet 2014",category:1},
    //     {id:2,title:"Lorem impsum dolor",date:"Juillet 2014",category:2},
    //     {id:3,title:"Architecture & bâtiment",date:"Juillet 2014",category:0},
    // ];

    var books = localStorageService.get('books');

    return {
        get: function(id) {
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
        get_by_id : function(id) {
            return {test:"test"};
        },
        saveLocal : function(data){
            localStorageService.set('books',data);
            console.log('saved books to localstorage')
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

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
        },
        add : function(data){
            var projects = localStorageService.get('projects');

            var last_id=0;

            for(var i in projects){
                last_id=projects[i].id;
            }
            data.id=last_id+1;

            projects.push(data);

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
        },
        validate : function(data){
            // Validation rules
            var titleMinLength=3,
                titleMaxLength=50,
                descMaxLength=1200,
                introMaxLength=100,
                dateMaxLength=100,
                tagMaxNumber=10,
                mediasMaxNumber=10;

            var msg=[];

            if(data.cover=="dist/img/sample.png")
                msg.push('ajoutez une photo de couverture');

            if(data.title.length<titleMinLength)
                msg.push('titre trop court');
            
            if(data.title.length>titleMaxLength)
                msg.push('titre trop long');

            if(data.desc.length>descMaxLength)
                msg.push('description trop longue');

            if(data.intro.length>introMaxLength)
                msg.push('introduction trop longue');

            if(data.date.length>dateMaxLength)
                msg.push('date trop longue');

            if(data.tags.length>tagMaxNumber)
                msg.push('trop de tags (maximum '+tagMaxNumber+')');

            if(data.files.length>mediasMaxNumber)
                msg.push('trop de fichiers (maximum '+mediasMaxNumber+')');

            if(msg.length==0){
                return true;
            }else{
                msg=msg.join(', ');
                msg = msg.charAt(0).toUpperCase() + msg.slice(1) + ".";
                return msg;
            }
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

            book.projects_a=projects_a_temp;

            return book;
        },
        saveLocal : function(data){
            localStorageService.set('books',data);
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
        },
        validate : function(data){
            // Validation rules
            var bottomlineMaxLength=150,
                btitleMinLength=2,
                btitleMaxLength=100,
                dateMaxLength=50,
                bottomlineMaxLength=100,
                subtitlelineMaxLength=500,
                minProjects=1;

            var msg=[];

            if(data.cover=="dist/img/sample.png")
                msg.push('ajoutez une photo de couverture');

            if(data.btitle.length<btitleMinLength)
                msg.push('titre trop court');
            
            if(data.btitle.length>btitleMaxLength)
                msg.push('titre trop long');

            if(data.projects_a.length<minProjects)
                msg.push('ajoutez au moins un projet');

            if(data.date.length>dateMaxLength)
                msg.push('date trop longue');

            if(data.bottomline.length>bottomlineMaxLength)
                msg.push('informations complémentaires trop longues');

            if(data.subtitle.length>subtitlelineMaxLength)
                msg.push('description trop longue');


            if(msg.length==0){
                return true;
            }else{
                msg=msg.join(', ');
                msg = msg.charAt(0).toUpperCase() + msg.slice(1) + ".";
                return msg;
            }
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

App.factory('Stats', function () {
  return {
    getForDashboard: function() {

        // DATES GENERATING
        var to = new Date();
        var from = new Date();
        from.setDate(from.getDate() - 14);

        var day;
        var dates = [];
        var dates_values = [];

        while(from <= to) {
            day = to.getDate()
            to = new Date(to.setDate(--day));
            var date = to.getDate()+'/'+(to.getMonth()+1)+'/'+to.getFullYear();
            dates.push(date);

            var val = Math.floor(Math.random()*301);
            dates_values.push(val);
        }

        // Big object
        var stats = {
            views : {
                web : {
                    today:Math.floor(Math.random()*100),
                    yesterday:(Math.floor(Math.random()*100)),
                    total:(Math.floor(Math.random()*2000)+2000)
                },
                pdf : {
                    today:Math.floor(Math.random()*100),
                    yesterday:(Math.floor(Math.random()*100)),
                    total:(Math.floor(Math.random()*2000)+2000)
                },
                pres : {
                    today:Math.floor(Math.random()*100),
                    yesterday:(Math.floor(Math.random()*100)),
                    total:(Math.floor(Math.random()*2000)+2000)
                },
                timeline : {
                    labels:dates,
                    data:dates_values
                }
            }
        };

        // Calculating totals
        stats.views.total = {
            today : stats.views.web.today+stats.views.pdf.today+stats.views.pres.today,
            yesterday : stats.views.web.yesterday+stats.views.pdf.yesterday+stats.views.pres.yesterday,
            total :  stats.views.web.total+stats.views.pdf.total+stats.views.pres.total
        }

        // Calculating growth
        stats.views.variations = {
            growth : Math.ceil(((stats.views.total.today-stats.views.total.yesterday)/stats.views.total.yesterday)*100),
            new_visits : stats.views.total.today-stats.views.total.yesterday
        }

        if(stats.views.variations.growth>=0)
            stats.views.variations.growth="+"+stats.views.variations.growth;

        if(stats.views.variations.new_visits>=0)
            stats.views.variations.new_visits="+"+stats.views.variations.new_visits;

        return stats;
    }
  };
});

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

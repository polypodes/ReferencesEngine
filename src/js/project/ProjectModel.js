App.factory('Projects',['localStorageService', function (localStorageService) {

    function checkExisting(data){
        if(data===null){
            localStorageService.set('projects',[]);
        }
    }

    return {
        get: function(id) {
            id = parseInt(id);

            var projects = localStorageService.get('projects');
            var temp_projects=[];
            checkExisting(projects);

            if(id!==0){
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
            id=parseInt(id);

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
            id=parseInt(id);
            
            var projects = localStorageService.get('projects');

            for(var i in projects){
                if(projects[i].id==id)
                    last_id=i;
            }

            projects[last_id]=data;
            localStorageService.set('projects',projects);
        },
        delete: function(id){
            id=parseInt(id);

            var projects = localStorageService.get('projects');
            var books = localStorageService.get('books');

            // Delete the project
            for(var i in projects){
                if(projects[i].id==id){
                    projects.splice(i,1);
                }
            }

            // Delete the project in books
            for(var j in books){
                for(var k in books[j].projects_a){
                    if(books[j].projects_a[k].id == id){
                        books[j].projects_a.splice(k,1);
                    }
                }                
            }

            localStorageService.set('projects',projects);
            localStorageService.set('books',books);
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

            if(msg.length===0){
                return true;
            }else{
                msg=msg.join(', ');
                msg = msg.charAt(0).toUpperCase() + msg.slice(1) + ".";
                return msg;
            }
        }
    };
}]);
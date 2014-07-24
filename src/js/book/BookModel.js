App.factory('Books', ['localStorageService', function (localStorageService) {

    function checkExisting(data){
        if(data===null){
            localStorageService.set('books',[]);
        }
    }

    return {
        get: function(id) {
            id=parseInt(id);

            var books = localStorageService.get('books');
            var temp_books=[];
            checkExisting(books);
            if(id!==0){
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

            id=parseInt(id);

            var books = localStorageService.get('books');
            checkExisting(books);

            for(var i in books){
                if(books[i].id==id){
                    return books[i];
                }
            }
        },
        saveLocal : function(data){
            localStorageService.set('books',data);
        },
        delete : function(id){
            id=parseInt(id);

            var books = localStorageService.get('books');

            // Delete from display
            for(var i in books){
                if(books[i].id==id){
                    books.splice(i,1);
                }
            }

            localStorageService.set('books',books);
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
            id=parseInt(id);
            
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
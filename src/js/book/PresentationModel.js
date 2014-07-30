presentApp.factory('Presentation', function () {
    return {
        getBook: function(id) {
            id=parseInt(id);

            var filename="_databooks.json";
            var path = dataPath+"/"+filename;            
            var data = node_fs.readFileSync(path,"utf-8");
            var books = angular.fromJson(data);

            var book;
            for(var i in books){
                if(books[i].id==id){
                    book = books[i];
                }
            }

            return book;
        }
    };
});
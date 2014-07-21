App.controller('BookEditorCtrl', ['$scope','Books','navService','$routeParams','Notify', function ($scope,Books,navService,$routeParams,Notify) {
    $scope.book = Books.getById($routeParams.book_id);
    $('link.template').attr('href',"src/templates/"+$scope.book.theme.src+".css");


    $scope.gridsterOpts = {
        columns: 4, // the width of the grid, in columns
        rows: 4, // the width of the grid, in columns
        pushing: true, // whether to push other items out of the way on move or resize
        floating: true, // whether to automatically float items up so they stack (you can temporarily disable if you are adding unsorted items with ng-repeat)
        width: 'auto', // can be an integer or 'auto'. 'auto' scales gridster to be the full width of its containing element
        colWidth: 'auto', // can be an integer or 'auto'.  'auto' uses the pixel width of the element divided by 'columns'
        rowHeight: 'match', // can be an integer or 'match'.  Match uses the colWidth, giving you square widgets.
        margins: [10, 10], // the pixel distance between each widget
        outerMargin: true, // whether margins apply to outer edges of the grid
        minColumns: 1, // the minimum columns the grid must have
        minRows: 1, // the minimum height of the grid, in rows
        maxRows: 4,
        defaultSizeX: 1, // the default width of a gridster item, if not specifed
        defaultSizeY: 1, // the default height of a gridster item, if not specified
        mobileBreakPoint: 1, // if the screen is not wider that this, remove the grid layout and stack the items
        resizable: {
           enabled: true,
           handles: 'se',
           start: function(event, uiWidget, $element) {}, // optional callback fired when resize is started,
           resize: function(event, uiWidget, $element) {}, // optional callback fired when item is resized,
           stop: function(event, uiWidget, $element) {} // optional callback fired when item is finished resizing
        },
        draggable: {
           enabled: true, // whether dragging items is supported
           start: function(event, uiWidget, $element) {}, // optional callback fired when drag is started,
           drag: function(event, uiWidget, $element) {}, // optional callback fired when item is moved,
           stop: function(event, uiWidget, $element) {} // optional callback fired when item is finished dragging
        }
    };
    
    $scope.info =function(){
      console.log($scope.book)
    }

    $scope.saveBook = function(){
        var book = $scope.book;

        var validation = Books.validate(book);
        if(validation!=true){
            Notify('error',"Erreur lors de l'ajout",validation);
            return false;
        }        

        if(book.id==null){

            // Create new a book
            var id = Books.add(book);
            Notify('success','Cahier ajouté','Le cahier a été ajouté à votre liste');

        }else if($routeParams.book_id!=undefined){

            // Edit a book
            var id = book.id;
            Books.edit(id,book);
            Notify('success','Cahier ajouté','Le cahier a été modifié avec succès');

        }
        
        Notify('success','Cahier modifié','Le cahier a été modifié avec succès');
    }

    $scope.pages = [
      {text:'cover'},
      {text:'page 1'},
      {text:'page 2'},
      {text:'page 3'},
      {text:'page 4'}
    ];

    // Scroll spy
    $scope.activePage=0;
    $('.preview').scroll(function(e){
      var pageh = $('.item').height()+20;
      var totop = Math.floor(($('.preview').scrollTop()-200)/pageh)+1;

      if(totop!=$scope.activePage){
        $scope.activePage=totop;
        $scope.$apply();
      }
    })


}]); 
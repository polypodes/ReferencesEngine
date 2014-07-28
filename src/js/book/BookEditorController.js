App.controller('BookEditorCtrl', ['$scope','Books','$routeParams','Notify','$location','$http','NavigationService','$cookieStore', function ($scope,Books,$routeParams,Notify,$location,$http,NavigationService,$cookieStore) {
 
    NavigationService.setPageTitle('Prévisualiser un cahier');
   
    $scope.book = Books.getById($routeParams.book_id);
    $('link.template').attr('href',"src/templates/"+$scope.book.theme.src+"/style.css");

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

    function getRandomUrl(){
      var v = "aeiouy".split(''),
          c = "bcdfghjklmnpqrstvwxz".split('');

      pass = "";
      for(var i=0; i<=5; i++){
        if((i%2)===0){
          pass+=v[Math.floor(Math.random()*(v.length))];
        }else{
          pass+=c[Math.floor(Math.random()*(c.length))];
        }
      }

      return pass;
    }

    function makeRequest(pass,overwrite){

      var ok = false;
      
      var data = $.param({file_title:pass,data:$scope.book,overwrite:overwrite});

      $http({
          url: 'templating/export.php',
          method: "POST",
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          data: data
      })
      .then(function(response) {
          console.log('response ------');
          console.log(response.data.error);
          console.log(overwrite);
          if(response.data.error!='ok' && overwrite!==true){
            Notify('error','Nom déjà utilisé',"Ce nom est déjà utilisé, veuillez en choisir un autre !");
            return false;
          }else{
            Notify('success','Votre cahier a été enregistré en ligne',"Votre cahier a bien été enregistré en ligne");
            $scope.book.exported=pass;
            $scope.exportBoxSuccess=true;

            // Edit a book
            Books.edit($scope.book.id,$scope.book);
          }
      }, 
      function(response) { // optional
        Notify('error','Erreur interne',"Une erreur s'est produite, contactez un administrateur ... Code d'erreur : REQ02");
      });
    }

    $scope.saveBook = function(showNotif){

        var validation = Books.validate($scope.book);
        if(validation!==true){
            Notify('error',"Erreur lors de l'enregistrement",validation);
            return false;
        }        

        if($routeParams.book_id!==undefined){

            // Edit a book
            Books.edit($scope.book.id,$scope.book);

            if(showNotif===true)
              Notify('success','Cahier modifié','Le cahier a été modifié avec succès');

            if($scope.book.exported!==false && showNotif===true){
              var exported = $scope.book.exported;

              makeRequest(exported,true);
            }
        }
    };

    $scope.pages = [
      {text:'cover'},
      {text:'page 1'},
      {text:'page 2'},
      {text:'page 3'},
      {text:'page 4'}
    ];

    // Scroll spy
    $scope.activePage=0;
    var pageh = 820;
    setTimeout(function(){
      pageh = $('.item').height()+20;
    },500);

    var steps = [0];
    var last_h=pageh;
    steps.push(last_h);
    for(var i in $scope.book.projects_a){
      if($scope.book.projects_a[i].files.length!==0){
        last_h+=2*pageh;
      }else{
        last_h+=pageh;
      }
      steps.push(last_h);
    } 

    var decal = $(document).height()-pageh+300;

    $('.preview').scroll(function(e){
      var totop = Math.floor(($('.preview').scrollTop())+decal);

      for(var i=0; i<steps.length-1; i++){
        
        if(totop>=steps[i] && totop<steps[i+1]){
          if($scope.activePage!=i){
            $scope.activePage=i;
            $scope.$apply();
          }
        }
      }
    
    });

    $scope.exportBox=false;
    $scope.exportBoxSuccess=false;

    $scope.export = function(){

      // reset scope show variables
      $scope.exportBox=false;
      $scope.exportBoxSuccess=false;

      if(!$scope.book.exported){
        $scope.exportBox=true;
        if($cookieStore.get('bTempUrl_'+$scope.book.id)){
          $scope.bookUrl=$cookieStore.get('bTempUrl_'+$scope.book.id);
        }else{
          $scope.bookUrl=getRandomUrl();
        }
      }else{

        $cookieStore.put('bTempUrl_'+$scope.book.id,$scope.book.exported);

        var data = $.param({file:$scope.book.exported+".json"});

        $http({
          url: 'templating/dexport.php',
          method: "POST",
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          data: data
        })
        .then(function(response) {
          if(response.data.error!='ok'){
              Notify('error','Erreur interne',"Une erreur s'est produite, contactez un administrateur ... Code d'erreur : REQ03");
          }else{
            Notify('success','Votre cahier a été mis hors ligne',"Celui-ci n'est désormais plus accessible aux visiteurs.");
            $scope.book.exported=false;
            $scope.saveBook(false);
          }
        }, 
        function(response) { // optional
          Notify('error','Erreur interne',"Une erreur s'est produite, contactez un administrateur ... Code d'erreur : REQ02");
        });
      }
      
      $scope.exportFinal = function(){
          makeRequest($scope.bookUrl,false);
      };

      return false;
     
    };

    $scope.closeExportedBox = function(){
      $scope.exportBox=false;
    };

}]); 
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
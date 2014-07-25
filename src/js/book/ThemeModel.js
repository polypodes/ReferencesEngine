App.factory('Themes', function () {
  return {
    get: function() {
        var themes = [
            {id:0,title:"Theme 1",src:"theme1",files:['main.js','jquery']},
            {id:1,title:"Theme 2",src:"theme2",files:['main.js','jquery']},
            {id:2,title:"Theme 3",src:"theme3",files:['main.js','jquery']},
            {id:3,title:"Theme 4",src:"theme4",files:['main.js','jquery']},
        ];
        return themes;
    }
  };
});
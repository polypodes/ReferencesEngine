App.config(['$routeProvider', function ($routeProvider) {

  $routeProvider
  .when('/projects/:project_id?', {
    templateUrl: 'src/views/projects.html',
    controller: 'ProjectsCtrl'
  })
  .when('/project/:project_id?', {
    templateUrl: 'src/views/project_add.html',
    controller: 'AddProjectCtrl'
  })
  .when('/books/:book_id?', {
    templateUrl: 'src/views/books.html',
    controller: 'BooksCtrl'
  })
  .when('/add_project', {
    templateUrl: 'src/views/project_add.html',
    controller: 'AddProjectCtrl'
  })
  .when('/add_book', {
    templateUrl: 'src/views/book_add.html',
    controller: 'AddBookCtrl'
  })
  .when('/overview', {
    templateUrl: 'src/views/overview.html',
    controller: 'OverviewCtrl'
  })
  .otherwise({
    redirectTo: '/overview'
  });

}]);
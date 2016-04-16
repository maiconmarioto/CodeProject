angular.module('app.controllers')
    .controller('ProjectListController',['$scope','Project','$routeParams',function($scope,Project,$routeParams){
        $scope.projects = Project.query();
    }]);
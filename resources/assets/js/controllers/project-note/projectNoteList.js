angular.module('app.controllers')
    .controller('ProjectNoteListController',['$scope','ProjectNote','$routeParams',function($scope,ProjectNote,$routeParams){
        $scope.projectNote = ProjectNote.query({
            id: $routeParams.id,
            noteId: $routeParams.noteId
        });
    }]);
angular.module('app.controllers')
    .controller('ProjectNoteRemoveController',
        ['$scope', '$location', '$routeParams', 'Client',
            function ($scope, $location, $routeParams, Client) {
                $scope.client = Client.get({id: $routeParams.id}); //pegando client

                $scope.remove = function () {
                    $scope.client.$delete().then(function () {
                        $location.path('/clients')
                    });
                }
            }]);
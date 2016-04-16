angular.module('app.services')
    .service('ProjectNote', ['$resource', 'appConfig', function ($resource, appConfig) {
        return $resource(appConfig.baseUrl + '/project/:id/note/:idNote', {
            id: '@id',
            noteId: '@idNote'
        }, {
            update: {
                method: 'PUT'
            },
        });
    }]);
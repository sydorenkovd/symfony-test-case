/**
 * Created by sydorenkovd on 21.10.17.
 */
var App = angular.module('App', []);
App.controller('AppContent', ['$scope', '$http', function ($scope, $http) {
    $scope.changeStatus = function (bookId) {
        $http.post('/api', {id: bookId, status: $scope.$formGet.bookStatus}).then(function(answer) {
            if(answer.status === 200) {
                window.location.reload()
            } else {
                $scope.error = 'Ощибка'
            }
        });
    };
}]);
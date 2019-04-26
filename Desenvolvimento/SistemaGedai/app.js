var app = angular.module('app', ['angularUtils.directives.dirPagination']);

app.controller('listarEventos', function($scope, $http){
 	$scope.dados = []; //declara uma array vazia com o nome 'dados'
   	$http({
  		method: 'GET',
  		url: 'http://localhost/SistemaGedai/client/Eventos/todos_os_eventos'
	}).then(function (response) {
            $scope.dados = response.data;
  	});
});

app.controller('listarArtigos', function($scope, $http){
 	$scope.artigos = []; //declara uma array vazia com o nome 'dados'
   	$http({
  		method: 'GET',
  		url: 'http://localhost/SistemaGedai/client/Artigo/todos_artigos'
	}).then(function (response) {
            $scope.artigos = response.data;
  	});
});


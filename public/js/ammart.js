(function(){
	
	var module = angular.module('ammart', [
		'ngRoute', 'questionaire', 'question', 'criterion', 'choice'
	])

	.config(function($interpolateProvider, $httpProvider, $locationProvider, $routeProvider){
		$interpolateProvider.startSymbol('[[').endSymbol(']]');
		$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

		$locationProvider.html5Mode(true);
		$routeProvider
			.when('/', {
				templateUrl: ''
			})
			.when('/home', {
				templateUrl: ''
			})
			.when('/sdq-eq', {
				templateUrl: 'sdq-eq',
				controller: 'QuestionaireListController',
				controllerAs: 'questionaireList'
			})
			.when('/form/create', {
				templateUrl: 'form/create',
				controller: 'QuestionaireCreateController',
				controllerAs: 'questionaireCreate'
			})
			.when('/report', {
				templateUrl: 'report'
			})
	})

})();
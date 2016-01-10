(function(){
	
	var module = angular.module('ammart', [
		'ngRoute', 'ngDialog',
		'questionaire', 'question', 'criterion', 'choice'
	])

	.config(function(
		$interpolateProvider, $httpProvider, 
		$locationProvider, $routeProvider, CSRF_TOKEN
	){
		$interpolateProvider.startSymbol('[[').endSymbol(']]');
		$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		$httpProvider.defaults.headers.common['X-Csrf-Token'] = CSRF_TOKEN;

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
			.when('/form/edit/:questionaireID', {
				templateUrl: 'form/edit/:questionaireID',
				controller: 'QuestionaireCreateController',
				controllerAs: 'questionaireCreate'
			})
			.when('/report', {
				templateUrl: 'report'
			})
	})

})();
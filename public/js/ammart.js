(function(){
	
	var module = angular.module('ammart', [
		'ngRoute', 'ngDialog', 'smart-table', 'angular-loading-bar',
		'questionaire', 'question', 'criterion', 'choice', 'report'
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
			.when('/auth/login', {
				templateUrl: 'auth/login'
			})
			.when('/auth/logout', {
				redirectTo: function(){
					window.location.href = 'auth/logout'
				}
			})
			.when('/auth/register', {
				templateUrl: 'auth/register'
			})
			.when('/forms', {
				templateUrl: 'forms',
				controller: 'QuestionaireListController',
				controllerAs: 'questionaireList'
			})
			.when('/form/create', {
				templateUrl: 'form/create',
			})
			.when('/form/edit/:questionaireID', {
				templateUrl: 'form/edit/:questionaireID',
			})
			.when('/teacher/risk-screening', {
				templateUrl: 'teacher/risk-screening',
			})
			.when('/teacher/risk-screening/:studentID', {
				templateUrl: 'teacher/risk-screening/:studentID',
			})
			.when('/questionaire/:questionaireID', {
				templateUrl: 'questionaire/:questionaireID',
				controller: 'QuestionaireDoController',
				controllerAs: 'questionaireDo'
			})
			.when('/report', {
				templateUrl: 'report',
			})
			.when('/report/:type', {
				templateUrl: 'report'
			})
			.when('/report/:type/:id', {
				templateUrl: 'report'
			})
	})

	.service('sys', function(ngDialog){
		this.error = function(msg) {
			ngDialog.open({
				plain: true,
				template: msg
			})
		}
	})

})();
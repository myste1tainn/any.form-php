(function(){
	
	var module = angular.module('ammart', [
		'ngRoute', 'ngDialog', 'smart-table', 'angular-loading-bar', 'ui.router',
		'questionaire', 'question', 'criterion', 'choice', 'report'
	])

	.config(function(
		$interpolateProvider, $httpProvider, $stateProvider, $urlRouterProvider,
		$locationProvider, $routeProvider, CSRF_TOKEN
	){
		$interpolateProvider.startSymbol('[[').endSymbol(']]');
		$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		$httpProvider.defaults.headers.common['X-Csrf-Token'] = CSRF_TOKEN;

		$locationProvider.html5Mode(true);
		$urlRouterProvider.otherwise('');
		$stateProvider
		.state('home', {
			url: '/home',
			templateUrl: ''
		})
		.state('auth/login', {
			url: '/auth/login',
			templateUrl: 'auth/login'
		})
		.state('auth/logout', {
			url: '/auth/logout',
			redirectTo: function(){
				window.location.href = 'auth/logout'
			}
		})
		.state('auth/register', {
			url: '/auth/register',
			templateUrl: 'auth/register'
		})
		.state('forms', {
			url: '/forms',
			templateUrl: 'forms',
			controller: 'QuestionaireListController',
			controllerAs: 'questionaireList'
		})
		.state('form/create', {
			url: '/form/create',
			templateUrl: 'form/create',
		})
		.state('form/edit/:questionaireID', {
			url: '/form/edit/:questionaireID',
			templateUrl: 'form/edit/:questionaireID',
		})
		.state('teacher/risk-screening', {
			url: '/teacher/risk-screening',
			templateUrl: 'teacher/risk-screening',
		})
		.state('teacher/risk-screening/:studentID', {
			url: '/teacher/risk-screening/:studentID',
			templateUrl: 'teacher/risk-screening/:studentID',
		})
		.state('questionaire/:questionaireID', {
			url: '/questionaire/:questionaireID',
			templateUrl: 'questionaire/:questionaireID',
			controller: 'QuestionaireDoController',
			controllerAs: 'questionaireDo'
		})
		.state('report', {
			url: '/report',
			templateUrl: 'report',
			deepStateRedirect: { default: { state: 'report.type'} },
		})
		.state('report.type', {
			url: '/:type',
			templateUrl: 'report',
			params: { type: 'person', form: null },
		})
		.state('report.type.form', {
			url: '/:type/:formId',
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
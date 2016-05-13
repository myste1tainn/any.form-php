(function(){
	
	var module = angular.module('ammart', [
		'ngRoute', 'ngDialog', 'smart-table', 'angular-loading-bar', 'ui.router', 'ngAnimate',
		'questionaire', 'question', 'criterion', 'choice', 'report', 'ct.ui.router.extras.dsr'
	])

	.config(function(
		$interpolateProvider, $httpProvider, $stateProvider, $urlRouterProvider,
		$locationProvider, $routeProvider, CSRF_TOKEN, $rootScopeProvider
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
		.state('login', {
			url: '/auth/login',
			templateUrl: 'auth/login'
		})
		.state('register', {
			url: '/auth/register',
			templateUrl: 'auth/register'
		})
		.state('forms', {
			url: '/forms',
			templateUrl: 'template/forms',
			controller: 'QuestionaireListController',
			controllerAs: 'questionaireList'
		})
		.state('risk-screening', {
			url: '/teacher/risk-screening',
			templateUrl: 'template/risk/do',
			controller: 'QuestionaireDoController',
			controllerAs: 'form',
		})
		.state('report', {
			url: '/report',
			controller: 'ReportNavigationController',
			controllerAs: 'nav',
			templateUrl: 'template/report/main',
			deepStateRedirect: { 
				default: { 
					state: 'report.overview',
					params: { type: 'person', form: null, formID: null },
				},
			},
		})
		.state('report.overview', {
			url: '/type/:type',
			views: {
				'report': {
					templateUrl: function($stateParams) {
						return 'template/report/'+$stateParams.type;
					},
					controller: 'ReportTabController',
					controllerAs: 'reportTab'
				}
			}
		})
		.state('report.risk', {
			url: '/:type/risk-screening',
			views: {
				'report': {
					templateUrl: function($stateParams) {
						return 'template/report-risk/'+$stateParams.type;
					},
					controller: 'ReportPersonRiskToolbarController',
					controllerAs: 'toolbar'
				}
			}
		})
		.state('report.risk.list', {
			url: '/list/:year',
			views: {
				'report.risk.body': {
					templateUrl: function($stateParams) {
						return 'template/report-risk/'+$stateParams.type+'-body';
					},
					controller: 'ReportPersonRiskListController',
					controllerAs: 'list'
				}
			}
		})
		.state('report.risk.detail', {
			url: '/participant/:participantID/year/:year',
			params: { participant: null, participantID: null },
			views: {
				'report.risk': {
					templateUrl: function($stateParams) {
						console
						return 'template/report-risk/'+$stateParams.type+'-detail';
					},
					controller: 'ReportRiskPersonDetailController',
					controllerAs: 'tab'
				}
			}
		})
	})

	.service('sys', function(ngDialog, $rootScope){
		this.dialog = {
			info: function(title, message) {
				ngDialog.open({
					template: message,
					plain: true
				})
			},
			error: function(object){
				ngDialog.open({
					template: (object.message === undefined) ? object : object.message,
					plain: true
				})
			},
			confirm: function(title, message, callback, autoDismiss) {
				if (autoDismiss === undefined) autoDismiss = true;
				ngDialog.open({
					template: 'template/dialog/confirm',
					controllerAs: 'dialog',
					controller: function($scope){
						this.title = title;
						this.message = message;
						this.confirm = function() {
							callback(this, true);
							if (autoDismiss) $scope.closeThisDialog();
						}
						this.decline = function() {
							callback(this, false);
							if (autoDismiss) $scope.closeThisDialog();
						}
					}
				})
			}
		}
	})

	.service('req', function($http, sys){
		this.getData = function(url, callback) {
			$http.get(url)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					var err = (res.message) ? res.message : res;
					sys.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res);
			});
		}
		this.getMessage = function(url, callback) {
			$http.get(url)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.message);
				} else {
					var err = (res.message) ? res.message : res;
					sys.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res);
			});
		}

		this.postData = function(url, payload, callback) {
			$http.post(url, payload)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					var err = (res.message) ? res.message : res;
					sys.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res);
			});
		}
		this.postMessage = function(url, payload, callback) {
			$http.post(url, payload)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.message);
				} else {
					var err = (res.message) ? res.message : res;
					sys.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res);
			});
		}
	})

	.controller('LoginController', function($scope) {
		console.log($scope);
	})

})();
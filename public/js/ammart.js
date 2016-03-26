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
		.state('teacher/risk-screening/year/:year/student/:studentID', {
			url: '/teacher/risk-screening/year/:year/student/:studentID',
			templateUrl: 'teacher/risk-screening/year/:year/student/:studentID',
		})
		.state('questionaire/:questionaireID', {
			url: '/questionaire/:questionaireID',
			templateUrl: 'questionaire/:questionaireID',
			controller: 'QuestionaireDoController',
			controllerAs: 'questionaireDo'
		})
		.state('report', {
			url: '/report',
			controller: 'ReportController',
			controllerAS: 'report',
			templateUrl: 'report',
			deepStateRedirect: { 
				default: { 
					state: 'report.type',
					params: { type: 'person' },
				},
			},
		})
		.state('report.type', {
			url: '/type/:type',
			controller: 'ReportController',
			controllerAS: 'report',
			templateUrl: 'report',
			params: { type: null },
			views: {
				'report.type': {
					templateUrl: function($stateParams) {
						var components = window.location.pathname.split('/');
						var count = components.length;
						var lastpart =  components[count - 1];

						if (lastpart == 'risk-screening') {
							return 'template/report-risk/'+$stateParams.type;
						} else {
							return 'template/report/'+$stateParams.type;
						}
					}
				}
			}
		})
		.state('report.type.form', {
			url: '/form/:formID',
			params: { type: null, form: null },
			views: {
				'report.type.form': {
					controller: 'ReportTabController',
					controllerAs: 'reportTab'
				}
			}
		})
		.state('report.type.risk', {
			url: '/risk-screening',
			params: { type: null, form: null },
			views: {
				'report.type.risk': {
					templateUrl: function($stateParams) {
						return 'template/report-risk/'+$stateParams.type;
					},
					controller: 'ReportRiskScreeningTabController',
					controllerAs: 'reportRiskScreeningTab'
				}
			}
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

	.directive('selectOption', function($http){
		return {
			restrict: 'A',
			controllerAs: 'select',
			controller: function($scope, $element, $attrs){
				var self = this;

				this.expanded = false;
				this.toggleExpand = function() {
					this.expanded = !this.expanded;
					if (this.expanded) {
						setTimeout(function() {
							angular.element('body').click(function(){
								$scope.$apply(function(){
									self.expanded = false;
									angular.element('body').off();
								});
							})
						}, 10);
					} else {
						angular.element('body').off();
					}
				}

				this.select = function(form) {
					$scope.form = form;
					$scope.stateChange($scope.type);
				}
			}
		}
	})

})();
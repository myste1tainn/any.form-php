(function(){
	
	var module = angular.module('ammart', [
		// Core
		'ngRoute', 'ngDialog', 'smart-table', 'angular-loading-bar', 'ui.router', 'ngAnimate',
		
		// Components
		'questionaire', 'question', 'criterion', 'choice', 'report', 'ct.ui.router.extras.dsr',

		// Collections
		'Questions', 'Groups'
	])

	.service('ArrayHelper', function(){

		var _removeBySplice = function(target, items){
			var index = items.indexOf(target);
			if (index > -1) {
				items.splice(index, 1);
				return true;
			} else {
				return false;
			}
		}

		var _searchByID = function(target, items){
			for (var i = items.length - 1; i >= 0; i--) {
				var item = items[i];
				if (item.id == target.id) {
					return item;
				}
			}
			return null;
		}

		this.remove = function(target, items) {
			if (!_removeBySplice(target, items)) {
				var item = _searchByID(target, items)
				if (item) {
					console.log(item, 'removed');
					items = _removeBySplice(item, items);
				}
			}
			return items;
		}
	})

	.config(function(
		$interpolateProvider, $httpProvider, $stateProvider, $urlRouterProvider,
		$locationProvider, $routeProvider, CSRF_TOKEN, $rootScopeProvider,
		RISK_ID, SDQ_ID, EQ_ID, CURRENT_YEAR
	){

		$interpolateProvider.startSymbol('[[').endSymbol(']]');
		$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		$httpProvider.defaults.headers.common['X-Csrf-Token'] = CSRF_TOKEN;

		$locationProvider.html5Mode(true);
		$urlRouterProvider.otherwise('');
		$stateProvider
		.state('home', {
			url: '/home',
		})
		.state('login', {
			url: '/auth/login',
			templateUrl: 'auth/login'
		})
		.state('register', {
			url: '/auth/register',
			templateUrl: 'auth/register'
		})
		.state('form', {
			url: '/form',
			templateUrl: 'template/head'
		})
		.state('form.list', {
			url: '/list',
			views: {
				'head': {
					templateUrl: 'template/form',
					controller: 'QuestionaireListController',
					controllerAs: 'list'
				}
			}
		})
		.state('form.do', {
			url: '/do/:formID',
			params: { formID: null, form: null },
			views: {
				'head': {
					templateUrl: 'template/form/do',
					controller: 'QuestionaireDoController',
					controllerAs: 'form'
				}
			}
		})
		.state('form-create', {
			url: '/form/create',
			params: { form: null, formID: null },
			templateUrl: 'form/create'
		})
		.state('form-edit', {
			url: '/form/edit/:formID',
			params: { form: null, formID: null },
			views: {
				'': {
					templateUrl: 'form/create',
				}
			}
		})
		.state('question-grouping', {
			url: '/question/grouping',
			views: {
				'': {
					templateUrl: 'template/question/grouping'
				}
			}
		})
		.state('question-grouping.show', {
			url: '/form/:formID/group/:groupID',
			params: { form: null, group: null },
			views: {
				'group': {
					templateUrl: 'template/question/grouping-body',
					controller: 'QuestionGroupController',
					controllerAs: 'grouper'
				}
			}
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
		})
		.state('report.overview', {
			url: '/type/:type/form/:formID/year/:year',
			params: { form: null, class: 1, room: 1, year: CURRENT_YEAR },
			views: {
				'report': {
					templateUrl: function($stateParams) {
						return 'template/report/'+$stateParams.type;
					},
					controller: 'ReportTabController',
					controllerAs: 'report'
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
				},
			}
		})
		.state('report.risk.overview', {
			url: '/year/:year',
			params: { form: null, class: 1, room: 1, from: 0, num: 10 },
			views: {
				'report.risk.overview': {
					templateUrl: 'template/report-risk/overview',
					controller: 'ReportRiskOverviewController',
					controllerAs: 'report'
				}
			}
		})
		.state('report.risk.list', {
			url: '/list/:year',
			params: { form: null, class: 1, room: 1, from: 0, num: 10 },
			views: {
				'report.risk.body': {
					templateUrl: function($stateParams) {
						return 'template/report-risk/'+$stateParams.type+'-body';
					},
					controller: 'ReportPersonRiskListController',
					controllerAs: 'list'
				},
			}
		})
		.state('report.risk.detail', {
			url: '/participant/:participantID/year/:year',
			params: { participant: null, participantID: null },
			views: {
				'report.risk': {
					templateUrl: function($stateParams) {
						return 'template/report-risk/'+$stateParams.type+'-detail';
					},
					controller: 'ReportRiskPersonDetailController',
					controllerAs: 'tab'
				}
			}
		})
		.state('report.sdq', {
			url: '/:type/sdq',
			params: { formID: null, form: null },
			views: {
				'report': {
					templateUrl: function($stateParams) {
						return 'template/report/sdq/'+$stateParams.type;
					},
					controller: 'SDQReportToolbarController',
					controllerAs: 'toolbar'
				},
			}
		})
		.state('report.sdq.list', {
			url: '/list/:year',
			views: {
				'report.sdq.body': {
					templateUrl: function($stateParams){
						return 'template/report/sdq/'+$stateParams.type+'-body';
					},
					controller: 'SDQReportListController',
					controllerAs: 'list'
				}
			}
		})
		.state('report.sdq.detail', {
			url: '/participant/:participantID/year/:year',
			views: {
				'report.sdq': {
					templateUrl: 'template/report/sdq/person-detail',
					controller: 'SDQReportDetailController',
					controllerAs: 'detail'
				}
			}
		})
		.state('report.sdq.overview', {
			url: '/year/:year',
			params: { class: null, room: null, year: CURRENT_YEAR },
			views: {
				'report.sdq.overview': {
					templateUrl: 'template/report/sdq/overview',
					controller: 'SDQReportOverviewController',
					controllerAs: 'overview'
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
					sys.dialog.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}
		this.getMessage = function(url, callback) {
			$http.get(url)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.message);
				} else {
					var err = (res.message) ? res.message : res;
					sys.dialog.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}

		this.postData = function(url, payload, callback) {
			$http.post(url, payload)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					var err = (res.message) ? res.message : res;
					sys.dialog.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}
		this.postMessage = function(url, payload, callback) {
			$http.post(url, payload)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.message);
				} else {
					var err = (res.message) ? res.message : res;
					sys.dialog.error(err);
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}
	})

	.service('User', function($http){
		var _this = this;

		this.name = null;
		this.level = null;

		$http.get('user')
		.success(function(res, status, headers, config){
			_this.name = res.name;
			_this.level = res.level;	

			if (_this.level === undefined) {
				_this.level = 0;
			}
		})
		.error(function(res, status, headers, config){
			
		});
	})

})();
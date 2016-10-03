(function(){
	
	var module = angular.module('ammart')

	.config(function($stateProvider, CURRENT_YEAR){
		$stateProvider
		.state('home', {
			url: '/home',
			templateUrl: 'template/home'
		})
		.state('login', {
			url: '/user/login',
			templateUrl: 'template/auth/login'
		})
		.state('logout', {
			url: '/user/logout',
			templateUrl: function() {
				window.location.href = "auth/logout";
			}
		})
		.state('register', {
			url: '/auth/register',
			templateUrl: 'auth/register'
		})
		.state('Forms', {
			url: '/forms',
			templateUrl: 'template/form/list',
			controller: 'FormListController'
		})
		.state('FormDo', {
			url: '/form/do/:formID',
			params: { formID: null, form: null },
			templateUrl: function($stateParams) {
				return 'template/form/'+$stateParams.formID;
			},
			controller: 'FormDoController'
		})
		.state('FormCreate', {
			url: '/form/create',
			params: { form: null, formID: null },
			templateUrl: 'template/form/create',
			controller: 'FormCreateController'
		})
		.state('FormEdit', {
			url: '/form/edit/:formID',
			params: { form: null, formID: null },
			templateUrl: 'template/form/create',
			controller: 'FormCreateController'
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
			controller: 'FormDoController',
			controllerAs: 'form',
		})
		.state('ReportDisplay', {
			url: '/report',
			controller: 'ReportFormSelectionController',
			templateUrl: 'template/report/common/main'
		})
		.state('ReportDisplay.List', {
			url: '/form/:formID/type/:type',
			params: {formID: null, type: 'person'},
			views: {
				'report-navigator': {
					controller: 'ReportNavigationController',
					templateUrl: function($stateParams) {
						if ($stateParams.type == 'person') {
							return 'template/controls/report-person-navigator';
						} else {
							return 'template/controls/report-navigator';
						}
					}
				},
				'report-body': {
					controller: 'ReportDataController',
					templateUrl: function($stateParams) {
						return `template/report/${$stateParams.formID}/by-${$stateParams.type}-list`;
					}
				}
			}
		})
		.state('ReportDisplay.Detail', {
			url: '/form/:formID/participant/:participantID/year/:year',
			views: {
				'report-navigator': '',
				'report-body': {
					controller: 'ReportDetailDataController',
					templateUrl: function($stateParams) {
						console.log($stateParams.formID);
						return `template/report/${$stateParams.formID}/by-person-detail`;
					}
				}
			}
		})
		.state('AdminDefinition', {
			url: '/admin/definition',
			templateUrl: 'template/definition/index',
		})
	})

})();
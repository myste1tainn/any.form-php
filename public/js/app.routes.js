(function(){
	
	var module = angular.module('ammart')

	.config(function(
		$stateProvider, RISK_ID, SDQ_ID, EQ_ID, CURRENT_YEAR
	){
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
				if ($stateParams.formID == RISK_ID) {
					return 'template/form/risk-screening';
				} else {
					return 'template/form/do';
				}
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
			templateUrl: 'template/report/main'
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
						if (!!!$stateParams.type) {
							return null;
						}
						if ($stateParams.formID == RISK_ID) {
							return 'template/report/risk/by-'+$stateParams.type+'-list';
						}
						if ($stateParams.formID == SDQ_ID) {
							return 'template/report/sdq/by-'+$stateParams.type+'-list';
						}
						if ($stateParams.formID == EQ_ID) {
							return 'template/report/eq/by-'+$stateParams.type+'-list';
						}
						// return `template/report/by-${stateParams.type}-list`;
						return 'template/report/by-'+$stateParams.type;
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
						if ($stateParams.formID == RISK_ID) {
							return 'template/report/risk/by-person-detail';
						}
						if ($stateParams.formID == SDQ_ID) {
							return 'template/report/sdq/by-person-detail';
						}
						if ($stateParams.formID == EQ_ID) {
							return 'template/report/eq/by-person-detail';
						}
						// return 'yes';
						return 'template/report/by-person-detail';
					}
				}
			}
		})
		.state('Definition', {
			url: '/admin/definition',
			templateUrl: 'template/definition/index'
		})

		// DEPRECATED
		.state('report.overview', {
			url: '/type/:type/form/:formID/year/:year',
			params: { form: null, class: 1, room: 1, year: CURRENT_YEAR },
			views: {
				'report-navigator': {
					controller: 'ReportNavigationController',
					templateUrl: 'template/controls/report-navigator',
				},
				'report-body': {
					templateUrl: function($stateParams) {
						return 'template/report/'+$stateParams.type;
					},
					controller: 'ReportTabController',
					controllerAs: 'report'
				}
			}
		})

		// DEPRECATED
		.state('report.risk', {
			url: '/:type/risk-screening',
			views: {
				'report-navigator': {
					controller: 'ReportNavigationController',
					templateUrl: 'template/controls/report-navigator',
				},
				'report-body': {
					templateUrl: function($stateParams) {
						return 'template/report-risk/'+$stateParams.type;
					},
					controller: 'ReportPersonRiskToolbarController',
					controllerAs: 'toolbar'
				},
			}
		})

		// DEPRECATED
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

})();
(function(){
	
	var module = angular.module('report', [
		'room', 'class', 'school'
	])

	.service('$report', function($http, sys){

		this.functionForType = function(type) {
			if (type === 'person') { return this.person; }
			else if (type === 'room') { return this.room; }
			else if (type === 'class') { return this.class; }
			else if (type === 'school') { return this.school; }
		}

		this.results = function(callback) {
			$http.get('report-results')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res);
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res);
			});
		}

		this.person = function(payload, callback) {
			$http.get('report-results/'+payload.id+'/person')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}

		this.school = function(payload, callback) {
			$http.get('report-results/'+payload.id+'/school')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}

		// this.room = function(id, callback) {
		this.room = function(payload, callback) {
			$http.get('report-results/'+payload.id+'/room/'+payload.class+'/'+payload.room)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}

		this.class = function(payload, callback) {
			$http.get('report-results/'+payload.id+'/class/'+payload.class)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}
	})

	.controller('ReportController', function($scope, $questionaire, $report, 
	                                         $compile, $state, $state, 
	                                         $class, RISK_ID) {
		var _ = this;

		$scope.forms 	= [];
		$scope.type 	= $state.current.type || 'person';
		$scope.form 	= $state.current.form || null;
		$scope.rooms 	= [];
		$scope.classes 	= [];
		$scope.room 	= null;
		$scope.class 	= null;

		if ($state.current.name == 'report.type' &&
		    $state.url === undefined) {
			var components = window.location.pathname.split('/');
			var count = components.length;
			$scope.type = components[count - 1];
		} else if ($state.current.name == 'report.type.form' &&
		           $state.url === undefined) {
			var components = window.location.pathname.split('/');
			var count = components.length;
			$scope.form = { id: components[count - 1] };
			$scope.type = components[count - 3];
		} else if ($state.current.name == 'report.type.risk' &&
		           $state.url === undefined) {
			var components = window.location.pathname.split('/');
			var count = components.length;
			$scope.form = { id: RISK_ID };
			$scope.type = components[count - 2];
		}

		var createDisplayedResult = function() {
			for (var i = $scope.forms.length - 1; i >= 0; i--) {
				var f = $scope.forms[i];
				f.displayedResults = [].concat(f.results);
			};
		}

		$questionaire.all(function(forms) {
			$scope.forms = forms;
			createDisplayedResult();
		})

		$scope.$on('$stateChangeStart', function(state, controller, params) {
			controller.params = params;
		})

		$scope.stateChange = function(state) {
			$scope.type = state;

			var changeStateBlock = function() {
				if ($scope.form) {
					if ($scope.form.id == RISK_ID) {
						// Move to special state if the form id is
						// Risk screening form id
						$state.go('report.type.risk', 
					          { 
					          	type: state, 
					          	form: $scope.form, 
					          	formID: $scope.form.id 
					          });
					} else {
						$state.go('report.type.form', 
					          { 
					          	type: state, 
					          	form: $scope.form, 
					          	formID: $scope.form.id 
					          });
					}
				} else {
					$state.go('report.type', { type: state, form: $scope.form });
				}
			}

			if ($scope.type == 'room' ||
			    $scope.type == 'class') {

				if ($scope.classes.length > 0) {
					changeStateBlock();
				} else {
					$class.all(function(res) {
						for (var i = res.classes.length - 1; i >= 0; i--) {
							var c = res.classes[i];
							$scope.classes.push({text:c.class, value:c.class});
						};

						for (var i = res.rooms.length - 1; i >= 0; i--) {
							var r = res.rooms[i];
							$scope.rooms.push({text:r.room, value:r.room});
						};

						$scope.class = $scope.classes[0];
						$scope.room = $scope.rooms[0];

						changeStateBlock();
					})
				}
			} else {
				changeStateBlock();
			}
		}

		var changeURL = function() {
			if ($scope.activeForm) {
				$state.go('report.type.form', { 
					type: $scope.activeType, 
					form: $scope.activeForm, 
					formId: $scope.activeForm.id 
				}).then(function() {
					$scope.report.currentTabController.getData();
				})
			} else {
				$state.go('report.type', { type: $scope.activeType });
			}
		}
	})

	.controller('ReportTabController', function($scope, $report, $state) {
		$scope.results 			= [];
		$scope.displayedResults = [];
		$scope.type 			= $state.current.params.type;
		$scope.form 			= $state.current.params.form;

		$scope.getData = function() {
			if ($scope.form !== undefined) {
				var fn = $report.functionForType($scope.type);
				var payload = {};

				if ($scope.type == 'person') {
					payload.id = $scope.form.id;
				} else if ($scope.type == 'room') {
					payload.id = $scope.form.id;
					payload.class = $scope.class.value;
					payload.room = $scope.room.value;
				} else if ($scope.type == 'class') {
					payload.id = $scope.form.id;
					payload.class = $scope.class.value;
				} else if ($scope.type == 'school') {
					payload.id = $scope.form.id;
				}

				fn(payload, function(result){
					$scope.results = result;
				})
			}
		}

		// Constructor behaviour depends on type
		if ($scope.type == 'person') {
			// Get Data Immediately
			if ($scope.form) $scope.getData();
		} else if ($scope.type == 'room') {			
			// Get class & room first then get data
			if ($scope.form) $scope.getData();
		} else if ($scope.type == 'class') {
			// Get class first then get data
			if ($scope.form) $scope.getData();
		} else if ($scope.type == 'school') {
			if ($scope.form) $scope.getData();
		}

		// For type: class & room, select option controlling
		$scope.classChange = function() {
			$scope.getData();
		}
		$scope.roomChange = function() {
			$scope.getData();
		}
	})

	.controller('ReportRiskScreeningTabController', function($scope, $state){
		this.selectedAspect = $state.params.aspect || null;
		$scope.participant = {
			identifier: 22611,
			firstname: 'อานนท์',
			lastname: 'คีรีนะ',
			class: '6',
			room: '4',
			number: '26',
			talent: 'บาสเก็ตบอล',
			disabilities: 'n/a',
			risks: {
				study: {
					high: [],
					veryHigh: []
				},
				health: {
					high: [],
					veryHigh: [{
						name: 'very high item 1 health'
					}, {
						name: 'very high item 2 health'
					}, {
						name: 'very high item 3 health'
					}]
				},
				aggressiveness: {
					high: [{
						name: 'high item 1 aggressiveness'
					}],
					veryHigh: [{
						name: 'very high item 1 aggressiveness'
					}, {
						name: 'very high item 2 aggressiveness'
					}, {
						name: 'very high item 3 aggressiveness'
					}, {
						name: 'very high item 3 aggressiveness'
					}, {
						name: 'very high item 3 aggressiveness'
					}, {
						name: 'very high item 3 aggressiveness'
					}, {
						name: 'very high item 3 aggressiveness'
					}, {
						name: 'very high item 3 aggressiveness'
					}, {
						name: 'very high item 3 aggressiveness'
					}]
				},
				economy: {
					high: [],
					veryHigh: []
				},
				security: {
					high: [{
						name: 'high item 1 security'
					}, {
						name: 'high item 2 security'
					}, {
						name: 'very high item 1 security'
					}, {
						name: 'very high item 2 security'
					}, {
						name: 'very high item 3 security'
					}],
					veryHigh: []
				},
				drugs: {
					high: [{
						name: 'high item 1 drugs'
					}, {
						name: 'high item 2 drugs'
					}],
					veryHigh: [{
						name: 'very high item 1 drugs'
					}, {
						name: 'very high item 2 drugs'
					}, {
						name: 'very high item 3 drugs'
					}]
				},
				sexuality: {
					high: [{
						name: 'high item 1 sexuality'
					}],
					veryHigh: [{
						name: 'very high item 1 sexuality'
					}]
				},
				games: {
					high: [{
						name: 'high item 1 games'
					}, {
						name: 'high item 2 games'
					}],
					veryHigh: []
				},
				electronics: {
					high: [],
					veryHigh: [{
						name: 'very high item 1 electronics'
					}, {
						name: 'very high item 2 electronics'
					}, {
						name: 'very high item 3 electronics'
					}]
				},
			}
		}

		this.selectAspect = function(aspect) {
			this.selectedAspect = aspect;

			var params = { aspectName: null, aspect: aspect };
			switch (aspect) {
				case $scope.participant.risks.study: params.aspectName = 'study'; break;
				case $scope.participant.risks.health: params.aspectName = 'health'; break;
				case $scope.participant.risks.aggressiveness: params.aspectName = 'aggressiveness'; break;
				case $scope.participant.risks.economy: params.aspectName = 'economy'; break;
				case $scope.participant.risks.security: params.aspectName = 'security'; break;
				case $scope.participant.risks.drugs: params.aspectName = 'drugs'; break;
				case $scope.participant.risks.sexuality: params.aspectName = 'sexuality'; break;
				case $scope.participant.risks.games: params.aspectName = 'games'; break;
				case $scope.participant.risks.electronics: params.aspectName = 'electronics'; break;
				default: break;
			}
		}

		this.isSelected = function(aspect) {
			return this.selectedAspect == aspect;
		}
	})

})();
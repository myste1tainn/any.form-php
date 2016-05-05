(function(){
	
	var module = angular.module('report', [
		'room', 'class', 'school', 'report.risk'
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
					sys.dialog.error(res);
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}

		this.person = function(payload, callback) {
			$http.get('report/by-person/'+payload.id+'/year/'+payload.year)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}

		this.school = function(payload, callback) {
			$http.get('report/by-school/'+payload.id+'/year/'+payload.year)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}

		// this.room = function(id, callback) {
		this.room = function(payload, callback) {
			$http.get('report/by-room/'+payload.id+'/class/'+payload.class+'/room/'+payload.room+'/year/'+payload.year)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}

		this.class = function(payload, callback) {
			$http.get('report/by-class/'+payload.id+'/class/'+payload.class+'/year/'+payload.year)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}
	})

	.controller('ReportNavigationController', function($scope, $questionaire, $report, $state, $class, RISK_ID)
	{
		var self = this;
		var _currentID = $state.params.formID || null;
		this.forms 	= $scope.forms = [];
		this.type 	= $state.params.type || 'person';
		this.form 	= $state.params.form || null;
		this.rooms 	= [];
		this.classes 	= [];
		this.room 	= null;
		this.class 	= null;

		/** Constructor
		 * Initial state controlling
		 */
		var components = window.location.pathname.split('/');
		var count = components.length;

		if ($state.current.name == 'report.overview' &&
			$state.url === undefined) {
			this.form = { id: components[count - 1] };
		}

		var createDisplayedResult = function() {
			for (var i = self.forms.length - 1; i >= 0; i--) {
				var f = self.forms[i];
				f.displayedResults = [].concat(f.results);
			};
		}

		$questionaire.all(function(forms) {
			self.forms = forms;
			createDisplayedResult();

			if (_currentID) {
				for (var i = self.forms.length - 1; i >= 0; i--) {
					var f = self.forms[i]
					if (f.id == _currentID) {
						self.form = f;
						break;
					}
				}
			} else {
				if ($state.current.name.indexOf('risk') > 1) {
					for (var i = self.forms.length - 1; i >= 0; i--) {
						var f = self.forms[i]
						if (f.id == RISK_ID) {
							self.form = f;
							break;
						}
					}	
				}
			}
		})

		/**
		 * State channging and controlling
		 */
		this.selectType = function(type) {
			this.type = type;

			var changeStateBlock = function() {
				var stateName = 'report.risk';
				if (self.form) stateName = (self.form.id == RISK_ID) ? 'report.risk' : 'report.overview';

				var form = self.form || null;
				var formID = (form == null) ? null : form.id;

				$state.go(stateName, { type: type, form: form, formID: formID });
			}


			// If this is of type room or class, loads all possible rooms & classes.
			if (this.type == 'room' ||
			    this.type == 'class') {

				if (this.classes.length > 0) {
					changeStateBlock();
				} else {
					$class.all(function(res) {
						for (var i = res.classes.length - 1; i >= 0; i--) {
							var c = res.classes[i];
							self.classes.push({text:c.class, value:c.class});
						};

						for (var i = res.rooms.length - 1; i >= 0; i--) {
							var r = res.rooms[i];
							self.rooms.push({text:r.room, value:r.room});
						};

						// Default select the first row found
						self.class = self.classes[0];
						self.room = self.rooms[0];

						changeStateBlock();
					})
				}
			} else {
				changeStateBlock();
			}
		}

		var changeURL = function() {
			if (self.activeForm) {
				$state.go('report.overview', { 
					type: self.activeType, 
					form: self.activeForm, 
					formId: self.activeForm.id 
				}).then(function() {
					self.report.currentTabController.getData();
				})
			} else {
				$state.go('report.overview', { type: self.activeType });
			}
		}

		/**
		 * UI Controlling part
		 */
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
			this.form = form;
			this.selectType(this.type);
		}
	})

	.controller('ReportTabController', function($scope, $report, $state) {
		$scope.results 			= [];
		$scope.displayedResults = [];
		$scope.type 			= $state.params.type;
		$scope.form 			= $state.params.form;

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

})();
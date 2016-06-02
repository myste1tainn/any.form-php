(function(){
	
	var module = angular.module('report', [
		'room', 'class', 'school', 
		'report.risk', 'report.sdq',
	])

	.service('$time', function() {
		var years = [];
		var countBack = 10;
		var currentYear = (new Date).getFullYear() + 543;
		var startYear = currentYear - countBack;
		var computedYear = 0;
		for (var i = 0; i < countBack + 1; i++) {
			computedYear = startYear + i;
			yearObj = {value:computedYear};
			years.push(yearObj);
		}

		this.years = function() {
			return years;
		}

		this.yearObjectForYear = function(year) {
			for (var i = years.length - 1; i >= 0; i--) {
				if (years[i].value == year) {
					return years[i];
				}
			}
		}
	})

	.service('$report', function($http, sys){

		this.numberOfPages = function(id, year, numRows, callback){
			$http.get(`api/v1/report/${id}/year/${year}/number-of-rows/${numRows}/number-of-pages`)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(function(res, status, headers, config){
				sys.dialog.error('Cannot get number of pages of report '+id);
			});
		}

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
			$http.get(`report/by-person/${payload.id}/year/${payload.year}/from/${payload.from}/num/${payload.num}`)
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
					sys.dialog.error(res);
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

	.controller('ReportNavigationController', function(
		$scope, 
		$questionaire, 
		$report,
		$state,
		$class, 
		RISK_ID, 
		SDQ_ID, 
		EQ_ID, 
		$time)
	{
		var self = this;
		var _currentID = $state.params.formID || null;
		this.forms 	= $scope.forms = [];
		this.type 	= $state.params.type || 'person';
		this.form 	= $state.params.form || null;
		this.rooms 	= [];
		this.classes = [];
		this.room 	= null;
		this.class 	= null;

		var currentYear = (new Date()).getFullYear() + 543;
		var pyear = $state.params.year || currentYear;
		this.years = $time.years();
		this.year = $time.yearObjectForYear(pyear);


		this.classChange = function() {
			$state.go('^.overview', {
				class: this.class.value,
				room: this.room.value,
				year: this.year.value,
			})
		}
		this.roomChange = function() {
			$state.go('^.overview', {
				class: this.class.value,
				room: this.room.value,
				year: this.year.value,
			})
		}
		this.yearChange = function() {
			$state.go('^.overview', {
				class: this.class.value,
				room: this.room.value,
				year: this.year.value,
			})
		}

		/** Constructor
		 * Initial state controlling
		 */
		var components = window.location.pathname.split('/');
		var count = components.length;

		if ($state.current.name == 'report.overview' &&
			$state.url === undefined) {
			this.form = { id: components[count - 3] };
		}

		var createDisplayedResult = function() {
			for (var i = self.forms.length - 1; i >= 0; i--) {
				var f = self.forms[i];
				f.displayedResults = [].concat(f.results);
			};
		}

		$questionaire.all(function(forms) {
			self.forms = forms;
			if (forms.length > 0) {
				self.form = forms[0];
			}
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
				} else if ($state.current.name.indexOf('sdq') > 1) {
					for (var i = self.forms.length - 1; i >= 0; i--) {
						var f = self.forms[i]
						if (f.id == SDQ_ID) {
							self.form = f;
							break;
						}
					}	
				} else if ($state.current.name.indexOf('eq') > 1) {
					for (var i = self.forms.length - 1; i >= 0; i--) {
						var f = self.forms[i]
						if (f.id == EQ_ID) {
							self.form = f;
							break;
						}
					}	
				}
			}
		})

		var changeStateBlock = function() {
			var stateName = 'report.overview';
			if (self.form) {
				if (self.form.id == RISK_ID) {
					stateName = 'report.risk';
				} else if (self.form.id == SDQ_ID) {
					stateName = 'report.sdq';
				} else if (self.form.id == EQ_ID) {
					stateName = 'report.eq';
				} else {
					stateName = 'report.overview';
				}

				var form = self.form || null;
				var formID = (form == null) ? null : form.id;

				$state.go(stateName, { type: self.type, form: form, formID: formID });
			}
		}

		var loadClasses = function() {
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

		var loadClassesIfNeeded = function() {
			// If this is of type room or class, loads all possible rooms & classes.
			if (self.type == 'room' ||
			    self.type == 'class') {

				if (self.classes.length > 0) {
					changeStateBlock();
				} else {
					loadClasses();
				}
			} else {
				changeStateBlock();
			}
		}

		/**
		 * State channging and controlling
		 */
		this.selectType = function(type) {
			this.type = type;
			loadClassesIfNeeded();
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

		loadClassesIfNeeded();
	})

	.controller('ReportTabController', function($scope, $report, $state) {
		$scope.results 			= [];
		$scope.displayedResults = [];
		$scope.type 			= $state.params.type;
		$scope.form 			= $state.params.form;

		if ($scope.$parent.nav) {
			$scope.$parent.nav.report = this;
			$scope.class = $scope.$parent.nav.class;
			$scope.room = $scope.$parent.nav.room;
		}

		$scope.getData = function() {

			if ($scope.form !== undefined) {
				var fn = $report.functionForType($scope.type);
				var payload = {};

				if ($scope.type == 'person') {
					payload.id = $scope.nav.form.id;
				} else if ($scope.type == 'room') {
					payload.id = $scope.nav.form.id;

					if ($scope.class && $scope.room) {
						payload.class = $scope.nav.class.value;
						payload.room = $scope.nav.room.value;
					} else {
						return;
					}

				} else if ($scope.type == 'class') {
					payload.id = $scope.form.id;

					if ($scope.class) {
						payload.class = $scope.nav.class.value;
					} else {
						return;
					}

				} else if ($scope.type == 'school') {
					payload.id = $scope.nav.form.id;
				}

				payload.year = $scope.nav.year.value;

				if (payload.id == "") {
					return;
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

		this.getData = function() {
			$scope.getData();
		}
	})

	.controller('PaginationController', function($scope, $report, $state){
		$scope.numRows = 10;
		$scope.numPage = 0;
		$scope.pages = [];
		$scope.currentPage = 0;

		$scope.year = { value: 2559 };

		$report.numberOfPages($scope.reportID, $scope.year.value, $scope.numRows, function(numPage){
			$scope.pages = [];
			$scope.numPage = numPage || 0;

			var limit = ($scope.numPage > 7) ? 7 : $scope.numPage;
			for (var i = 0; i <= limit; i++) {
				$scope.pages.push(i);
			}
		})

		$scope.changePage = function(page) {
			$scope.currentPage = page;
			var params = {
				class: $scope.class.value,
				room: $scope.room.value,
				year: $scope.year.value,
				from: $scope.currentPage * $scope.numRows,
				num : $scope.numRows
			};

			var last = $scope.pages.length - 1;
			if ($scope.currentPage == $scope.pages[last] && last > 0) {
				$scope.pages.shift();
				$scope.pages.push($scope.pages[last - 1] + 1);
			}
			if ($scope.currentPage == $scope.pages[0] && $scope.pages[0] != 0) {
				for (var i = $scope.pages.length - 1; i >= 0; i--) {
					$scope.pages[i]--;
				}
			}

			$state.go($scope.stateName, params);
		}
	})

})();
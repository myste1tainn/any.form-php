(function(){
	
	var module = angular.module('report', [
		'room', 'class', 'school', 'report.service',
		'report.risk', 'report.sdq', 'report.navigation'
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

	.controller('ReportDisplayController', function($scope, $state, ReportFormSelectionControllerDelegate) {
		$scope.currentForm = $state.params.form || null;
		$scope.currentType = $state.params.type || null;

		var _changeStateIfNeeded = function() {
			console.log(!!$scope.currentForm, !!$scope.currentType);
			console.log($scope.currentForm, $scope.currentType);
			if (!!$scope.currentForm && !!$scope.currentType) {
				_form = $scope.currentForm;
				_type = $scope.currentType;

				console.log('called');

				$state.go('ReportDisplay.Show', {
					formID: _form.id,
					type: _type.value
				})
			}
		}

		$scope.onFormChange = function(form) {
			console.log(form);
			$scope.currentForm = form;
			_changeStateIfNeeded();
		}
		$scope.onTypeChange = function(type) {
			console.log(type);
			$scope.currentType = type;
			_changeStateIfNeeded();
		}

		_delegation = ReportFormSelectionControllerDelegate;
		_delegation.onFormChange = $scope.onFormChange;
		_delegation.onTypeChange = $scope.onTypeChange;
	})

	.controller('ReportTabController', function($scope, reportService, $state) {
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
				var fn = reportService.functionForType($scope.type);
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

	.controller('PaginationController', function($scope, reportService, $state){
		$scope.numRows = 10;
		$scope.numPage = 0;
		$scope.pages = [];
		$scope.currentPage = 0;

		$scope.year = { value: 2559 };

		reportService.numberOfPages($scope.reportID, $scope.year.value, $scope.numRows, function(numPage){
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
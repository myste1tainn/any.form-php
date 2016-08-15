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
			if (!!$scope.currentForm && !!$scope.currentType) {
				var _form = $scope.currentForm;
				var _type = $scope.currentType;
				$state.go('ReportDisplay.Show', {
					formID: _form.id,
					form: _form,
					type: _type.value
				})
			}
		}

		$scope.onFormChange = function(form) {
			$scope.currentForm = form;
			_changeStateIfNeeded();
		}
		$scope.onTypeChange = function(type) {
			$scope.currentType = type;
			_changeStateIfNeeded();
		}

		_delegation = ReportFormSelectionControllerDelegate;
		_delegation.onFormChange = $scope.onFormChange;
		_delegation.onTypeChange = $scope.onTypeChange;
	})

	.controller('ReportDataController', function(
		$scope, reportService, $state,
		ReportNavigationControllerDelegate
	) {
		console.log('loaded', $state.params);
		_delegation = ReportNavigationControllerDelegate
		$scope.results 			= [];
		$scope.displayedResults = [];
		$scope.type 			= $state.params.type;
		$scope.form 			= $state.params.form;

		$scope.getData = function() {

			if ($scope.form !== undefined) {
				var fn = reportService.functionForType($scope.type);
				var payload = {};

				if ($scope.type == 'person') {
					payload.id = $scope.form.id;
				} else if ($scope.type == 'room') {
					payload.id = $scope.form.id;

					if ($scope.class && $scope.room) {
						payload.class = $scope.class.value;
						payload.room = $scope.room.value;
					} else {
						return;
					}

				} else if ($scope.type == 'class') {
					payload.id = $scope.form.id;

					if ($scope.class) {
						payload.class = $scope.class.value;
					} else {
						return;
					}

				} else if ($scope.type == 'school') {
					payload.id = $scope.form.id;
				}

				// CONTINUE ON THIS
				// Error: Cannot read property value of undefined
				// You should call onYearChange when the year is loaded and set on navigation controller
				payload.year = $scope.year.value;

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

		_delegation.onYearChange = function(year){
			console.log('called     onYearChange');
			$scope.year = year;
			$scope.getData();
		}
		_delegation.onClassChange = function(c) {
			console.log('called     onClassChange');
			$scope.class = c;
			$scope.getData();
		}
		_delegation.onRoomChange = function(room){
			console.log('called     onRoomChange');
			$scope.room = room;
			$scope.getData();
		}
		_delegation.onPageChange = function(page){
			console.log('called     onPageChange');
			$scope.page = page;
			$scope.getData();
		}
	})

})();
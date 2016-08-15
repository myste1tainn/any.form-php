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
		ReportNavigationControllerDelegate, ReportFormSelectionControllerDelegate
	) {
		_delegation = ReportNavigationControllerDelegate;
		_formSelectionController = ReportFormSelectionControllerDelegate.formSelectionController;

		$scope.results 			= [];
		$scope.displayedResults = [];
		$scope.type 			= _formSelectionController.selectedType;
		$scope.form 			= _formSelectionController.selectedForm;

		$scope.getData = function() {
			if (!!$scope.form && !!$scope.type) {
				var fn = reportService.functionForType($scope.type);
				var clazz = (!!_delegation.navigationController.class) ? _delegation.navigationController.class.value : null;
				var room = (!!_delegation.navigationController.room) ? _delegation.navigationController.room.value : null;
				var year = (!!_delegation.navigationController.year) ? _delegation.navigationController.year.value : null;
				var from = _delegation.navigationController.numRows * _delegation.navigationController.currentPage;
				var payload = {
					id: $scope.form.id,
					class: clazz,
					room: room,
					year: year,
					from: from,
					num: _delegation.navigationController.numRows
				};

				fn(payload, function(result){
					$scope.results = result;
				})
			}
		}

		_delegation.onReloadData 	= $scope.getData;
		_delegation.onYearChange 	= $scope.getData;
		_delegation.onClassChange 	= $scope.getData;
		_delegation.onRoomChange	= $scope.getData;
		_delegation.onPageChange	= $scope.getData;
	})

})();
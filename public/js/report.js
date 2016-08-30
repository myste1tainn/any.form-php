(function(){
	
	var module = angular.module('report', [
		'room', 'class', 'school', 'report.service',
		'report.risk', 'report.sdq', 'report.navigation'
	])

	.service('timeService', function() {
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

	.controller('ReportDisplayController', function(
		$scope, $state, ReportFormSelectionService, ReportNavigationService
	) {
		ReportFormSelectionService.formSelectionController.setDelegate($scope);

		$scope.currentFormID = $state.params.formID || null;
		$scope.currentType = $state.params.type || null;

		var _changeStateIfNeeded = function() {
			if (!!$scope.currentFormID && !!$scope.currentType) {
				var _formID = $scope.currentFormID;
				var _type = $scope.currentType;
				$state.go('ReportDisplay.List', {
					formID: _formID,
					type: (typeof _type == 'object') ? _type.value : _type
				})
			}
		}

		ReportFormSelectionService.formSelectionController.setDelegate($scope);

		$scope.formSelectionDidChangeForm = function(s, form) {
			$scope.currentFormID = form.id;
			_changeStateIfNeeded();
		}
		$scope.formSelectionDidChangeType = function(s, type) {
			$scope.currentType = type;
			_changeStateIfNeeded();
		}
	})

	.controller('ReportDataController', function(
		$scope, reportService, classService, timeService, $state,
		ReportNavigationService, ReportFormSelectionService, RISK_ID
	) {
		// Implement super class;
		ReportPagingationDataSource.call($scope);
		ReportNavigationControllerDelegate.call($scope);

		var _class, _room, _year, _page = 0, _numRows = 10, _numPage = 5;
		var _classes, _rooms, _years, _pages = [], _formSelectionController, _navigationController;
		$scope.constructor = function() {
			_formSelectionController = ReportFormSelectionService.formSelectionController;
			_navigationController = ReportNavigationService.navigationController;
			
			if (_navigationController) {
				_navigationController.setDelegate($scope);
				_navigationController.setDataSource($scope);
			}

			$scope.results 			= [];
			$scope.displayedResults = [];
			$scope.type 			= _formSelectionController.selectedType;
			_formID 				= $state.params.formID;

			$scope.getRequiredData();
			if ($state.current.name == 'ReportDisplay.List') {
				$scope.getReportPagesInfo();
			} else {
				$scope.getData();
			}
		}

		$scope.getRequiredData = function() {
			if ($state.current.name == 'ReportDisplay.List') {
				if ($scope.type.value == 'person' || $scope.type.value == 'school') {

				} else if ($scope.type.value == 'class' || $scope.type.value == 'room') {
					// These two types need class/room data
					$scope.getClasses();
				}
			}
			$scope.getYears();
		}

		$scope.getClasses = function() {
			classService.loadClassesAndRooms(function(res) {
				_classes = res.classes;
				_rooms = res.rooms;

				_navigationController.reloadData();
			})
		}

		$scope.getYears = function() {
			var currentYear = (new Date()).getFullYear() + 543;
			var pyear = $state.params.year || currentYear;
			_years = timeService.years();
			_year = timeService.yearObjectForYear(pyear);
			
			if (_navigationController) {
				_navigationController.reloadData();
				_navigationController.selectYear(_year);
			}
		}

		$scope.getReportPagesInfo = function() {
			if (!!!_formID || $state.current.name == 'ReportDisplay.Detail') return;
			
			reportService.numberOfPages(_formID, _year.value, _numRows, function(numPage){
				for (var i = 0; i <= numPage; i++) {
					_pages.push(i);
				}
				_navigationController.reloadData();
			})
		}

		var _canDoRequestWithPayload = function(payload){
			if ($scope.type.value == 'person' || $scope.type.value == 'school') {
				return true;
			} else if ($scope.type.value == 'class') {
				if (!!payload.year && !!payload.class) {
					return true;
				}
			} else if ($scope.type.value == 'room') {
				if (!!payload.year && !!payload.class && !!payload.room) {
					return true;
				}
			}
			return false;
		}

		var _getListData = function() {
			console.log('called');
			if (!!_formID && !!$scope.type) {
				var fn = reportService.functionForType($scope.type);
				var clazz = (!!_class) ? _class.value : null;
				var room = (!!_room) ? _room.value : null;
				var year = (!!_year) ? _year.value : null;
				var from = _numRows * _page;
				var payload = {
					id: _formID,
					class: clazz,
					room: room,
					year: year,
					from: from,
					num: _numRows
				};

				if (_canDoRequestWithPayload(payload)) {

					fn(payload, function(result){
						$scope.results = result;

						if (_formID == RISK_ID) {
							for (var i = 0; i < $scope.results.length; i++) {
								$scope.results[i].hasTalent = function() {
									return !!this.talent;
								}
							}
						}
					})
				}
			}
		}

		$scope.getData = function() {
			_getListData();
		}

		// MARK: Report Navigation Data Source
		$scope.yearsForNavigationController = function(nav) {
			return _years;
		}
		$scope.classesForNavigationController = function(nav) {
			return _classes;
		}
		$scope.roomsForNavigationController = function(nav) {
			return _rooms;
		}
		$scope.pagesForNavigationController = function(nav) {
			return { pages: _pages, numberOfPageDisplay: _numPage };
		}

		// MARK: Report Navigation Delegate
		$scope.navigationControllerDidChangeYear = function(nav, year) {
			_year = year;
			$scope.getData();
		}
		$scope.navigationControllerDidChangeClass = function(nav, clazz) {
			_class = clazz;
			$scope.getData();
		}
		$scope.navigationControllerDidChangeRoom = function(nav, room) {
			_room = room;
			$scope.getData();
		}
		$scope.navigationControllerDidChangePage = function(nav, page) {
			_page = page;
			$scope.getData();
		}

		$scope.showDetail = function(participant) {
			var _type = $state.params.type;

			$state.go('ReportDisplay.Detail', {
				participantID: participant.identifier,
				year: _year.value,
				formID: _formID,
				type: (typeof _type == 'object') ? _type.value : _type
			})
		}

		$scope.constructor();
	})

	// The controller should have ability to selectSubDetail() -- e.g. Aspect of risks in Risk-screening report
	.controller('ReportDetailDataController', function(
		$scope, reportService, classService, timeService, $state,
		ReportNavigationService, ReportFormSelectionService, injector
	) {
		$scope.constructor = function(){
			injector.parseAndInject($scope, 'form');
			injector.parseAndInject($scope, 'participant', 'identifier');
			injector.parseAndInject($scope, 'year');

			$scope.getData();
		}

		var _getDetailData = function() {
			reportService.participantResult(
				$scope._participant.identifier, 
				$scope._form.id, 
				$scope._year, 
			function(result) {
				$scope.results = result;
			})
		}

		$scope.getData = function() {
			_getDetailData();
		}

		$scope.selectSubdetail = function(subdetail){
			$scope.subdetail = subdetail;
		}

		$scope.constructor();
	})
})();
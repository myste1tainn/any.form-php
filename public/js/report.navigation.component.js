(function(){
	
	var module = angular.module('report.navigation', [])

	.service('ReportFormSelectionControllerDelegate', function() {
		this.formSelectionController = null;
		this.onFormChange = null;
		this.onTypeChange = null;

		this.formChange = function(form) {
			if (this.onFormChange) {
				this.onFormChange(form)
			}
		}
		this.typeChange = function(type) {
			if (this.onTypeChange) {
				this.onTypeChange(type)
			}
		}
	})

	.service('ReportNavigationControllerDelegate', function() {
		this.navigationController = null;
		this.onReloadData = null;
		this.onClassChange = null;
		this.onRoomChange = null;
		this.onYearChange = null;
		this.onPageChange = null;

		this.reloadData = function() {
			if (this.onReloadData) {
				this.onReloadData();
			}
		}

		this.classChange = function(c) {
			if (this.onClassChange) {
				this.onClassChange(c)
			}
		}
		this.roomChange = function(room) {
			if (this.onRoomChange) {
				this.onRoomChange(room)
			}
		}
		this.yearChange = function(year) {
			if (this.onYearChange) {
				this.onYearChange(year)
			}
		}
		this.pageChange = function(page) {
			if (this.onPageChange) {
				this.onPageChange(page)
			}
		}
	})

	/*
		Control form & type selection
	*/
	.controller('ReportFormSelectionController', function(
		$scope, $state, reportService, formService, ArrayHelper,
		ReportFormSelectionControllerDelegate
	){
		var _currentID = $state.params.formID || localStorage.getItem('formID') || null;
		var _delegation;
		_delegation = ReportFormSelectionControllerDelegate;
		_delegation.formSelectionController = $scope;
		$scope.expanded = false;
		$scope.forms = [];
		$scope.selectedForm = null;
		$scope.types = reportService.reportTypes;
		$scope.selectedType = ArrayHelper.find($state.params.type, $scope.types, 'value');

		// Set forms list and select the current (if any)
		var _setForms = function(forms) {
			$scope.forms = forms;
			if (!!_currentID) {
				$result = ArrayHelper.find({id:_currentID}, forms);
				if ($result) {
					$scope.selectedForm = $result;
					_delegation.formChange($result);
				}
			}
		}

		formService.load(function(forms) {
			_setForms(forms);
		})

		var _writeToLocal = function(form){
			localStorage.setItem('formID', form.id);
		}

		$scope.toggleExpand = function() {
			$scope.expanded = !$scope.expanded;
			if ($scope.expanded) {
				setTimeout(function() {
					angular.element('body').click(function(){
						$scope.$apply(function(){
							$scope.expanded = false;
							angular.element('body').off();
						});
					})
				}, 10);
			} else {
				angular.element('body').off();
			}
		}

		$scope.selectForm = function(form) {
			$scope.selectedForm = form;
			$scope.toggleExpand();
			_delegation.formChange(form);

			_writeToLocal(form);
		}


		$scope.selectType = function(type) {
			$scope.selectedType = type;
			_delegation.onTypeChange(type);
		}
	})

	.controller('ReportNavigationController', function(
		$scope, reportService, $state, $class, $time,
		ReportNavigationControllerDelegate)
	{
		var _delegation;

		$scope.constructor = function(){
			// For shorthand
			_delegation = ReportNavigationControllerDelegate;

			// Set this scope as current controller of the navigation
			_delegation.navigationController = $scope;

			$scope.rooms 	= [];
			$scope.classes 	= [];
			$scope.room 	= null;
			$scope.class 	= null;
			$scope.currentPage = 0;

			var currentYear = (new Date()).getFullYear() + 543;
			var pyear = $state.params.year || currentYear;
			$scope.years = $time.years();
			$scope.year = $time.yearObjectForYear(pyear);

			// Call for change once for each the recently set data
			$scope.classChange();
			$scope.roomChange();
			$scope.changePage(0);
			$scope.yearChange(); 

			var loadClasses = function() {
// TODO: This should be moved to data controller, navigation shouldn't know where to get
				$class.all(function(res) {
					for (var i = res.classes.length - 1; i >= 0; i--) {
						var c = res.classes[i];
						$scope.classes.push({text:c.class, value:c.class});
					};

					for (var i = res.rooms.length - 1; i >= 0; i--) {
						var r = res.rooms[i];
						$scope.rooms.push({text:r.room, value:r.room});
					};

					// Default select the first row found
					$scope.class = $scope.classes[0];
					$scope.room = $scope.rooms[0];
				})
			}

			var loadClassesIfNeeded = function() {
				// If this is of type room or class, loads all possible rooms & classes.
				if ($scope.type == 'room' ||
				    $scope.type == 'class') {

					if ($scope.classes.length > 0) {
						
					} else {
						loadClasses();
					}
				}
			}

			loadClassesIfNeeded();

			/*******************
			* Pagination
			*******************/

			$scope.numRows = 10;
			$scope.numPage = 0;
			$scope.pages = [];
			$scope.currentPage = 0;

			var _loadNumberOfPageIfNeeded = function(){
				if (!!!$scope.reportID || !!!$scope.year.value || !!!$scope.numRows) {
					// Either one of these not exists, do not load
					return;
				}

// TODO: This should be moved to data controller, navigation shouldn't know where to get number of pages
				reportService.numberOfPages($scope.reportID, $scope.year.value, $scope.numRows, function(numPage){
					$scope.pages = [];
					$scope.numPage = numPage || 0;

					var limit = ($scope.numPage > 7) ? 7 : $scope.numPage;
					for (var i = 0; i <= limit; i++) {
						$scope.pages.push(i);
					}
				})
			}
			_loadNumberOfPageIfNeeded();
		}

		$scope.getData = function(){
			_delegation.reloadData();
		}

		$scope.classChange = function() {
			if (!!$scope.class) {
				_delegation.classChange($scope.class.value);
			}
		}
		$scope.roomChange = function() {
			if (!!$scope.room) {
				_delegation.roomChange($scope.room.value);
			}
		}
		$scope.yearChange = function() {
			if (!!$scope.year) {
				_delegation.yearChange($scope.year.value);
			}
		}

		$scope.changePage = function(page) {
			$scope.currentPage = page;
			_delegation.pageChange(page);
			// var params = {
			// 	class: $scope.class.value,
			// 	room: $scope.room.value,
			// 	year: $scope.year.value,
			// 	from: $scope.currentPage * $scope.numRows,
			// 	num : $scope.numRows
			// };

// TODO: Uncomment this to allow proper pagination
			// var last = $scope.pages.length - 1;
			// if ($scope.currentPage == $scope.pages[last] && last > 0) {
			// 	$scope.pages.shift();
			// 	$scope.pages.push($scope.pages[last - 1] + 1);
			// }
			// if ($scope.currentPage == $scope.pages[0] && $scope.pages[0] != 0) {
			// 	for (var i = $scope.pages.length - 1; i >= 0; i--) {
			// 		$scope.pages[i]--;
			// 	}
			// }

			// $state.go($scope.stateName, params);
		}

		$scope.constructor();
	})

})();
(function(){
	
	var module = angular.module('report.navigation', [])

	.service('ReportFormSelectionControllerDelegate', function() {
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
		this.onClassChange = null;
		this.onRoomChange = null;
		this.onYearChange = null;
		this.onPageChange = null;

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
		$scope.delegate = ReportFormSelectionControllerDelegate;
		$scope.expanded = false;
		$scope.forms = [];
		$scope.selectedForm = null;
		$scope.types = reportService.reportTypes;
		$scope.selectType = null;

		// Set forms list and select the current (if any)
		var _setForms = function(forms) {
			$scope.forms = forms;
			if (!!_currentID) {
				$result = ArrayHelper.find({id:_currentID}, forms);
				if ($result) {
					$scope.selectedForm = $result;
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
			$scope.delegate.onFormChange(form);

			_writeToLocal(form);
		}


		$scope.selectType = function(type) {
			$scope.selectedType = type;
			$scope.delegate.onTypeChange(type);
		}
	})

	.controller('ReportNavigationController', function(
		$scope, reportService, $state, $class, $time,
		ReportNavigationControllerDelegate)
	{
		_delegation = ReportNavigationControllerDelegate;
		$scope.rooms 	= [];
		$scope.classes 	= [];
		$scope.room 	= null;
		$scope.class 	= null;

		var currentYear = (new Date()).getFullYear() + 543;
		var pyear = $state.params.year || currentYear;
		$scope.years = $time.years();
		$scope.year = $time.yearObjectForYear(pyear);

		$scope.classChange = function() {
			_delegation.onClassChange($scope.class.value);
		}
		$scope.roomChange = function() {
			_delegation.onRoomChange($scope.room.value);
		}
		$scope.yearChange = function() {
			_delegation.onYearChange($scope.year.value);
		}

		var changeStateBlock = function() {
			var stateName = 'report.overview';
			
			if ($scope.form && !$scope.form.injectedFunctions) {
				formService.injectFunctions($scope.form);
			}

			if ($scope.form) {
				var form = $scope.form;
				var formID = form.id;

				localStorage.setItem('formID', form.id);
				$state.go(stateName, { type: $scope.type, form: form, formID: formID });
			}
		}

		var loadClasses = function() {
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

				changeStateBlock();
			})
		}

		var loadClassesIfNeeded = function() {
			// If this is of type room or class, loads all possible rooms & classes.
			if ($scope.type == 'room' ||
			    $scope.type == 'class') {

				if ($scope.classes.length > 0) {
					changeStateBlock();
				} else {
					loadClasses();
				}
			} else {
				changeStateBlock();
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

		$scope.changePage = function(page) {
			$scope.currentPage = page;
			_delegation.onPageChange(page);
			// var params = {
			// 	class: $scope.class.value,
			// 	room: $scope.room.value,
			// 	year: $scope.year.value,
			// 	from: $scope.currentPage * $scope.numRows,
			// 	num : $scope.numRows
			// };

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
	})

})();
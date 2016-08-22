(function(){
	
	var module = angular.module('report.navigation', [])

	.service('ReportFormSelectionService', function() {
		this.formSelectionController = null;
	})

	.service('ReportNavigationService', function() {
		this.navigationController = null;
	})

	/*
		Control form & type selection
	*/
	.controller('ReportFormSelectionController', function(
		$scope, $state, reportService, formService, ArrayHelper,
		ReportFormSelectionService
	){
		var _currentID = $state.params.formID || localStorage.getItem('formID') || null;
		var _reportNavigationSerivce;
		var _delegate = null;

		_reportNavigationSerivce = ReportFormSelectionService;
		_reportNavigationSerivce.formSelectionController = $scope;
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
					if (_delegate) {
						// TODO: Determine if this is needed (form change event from data loading)
						_delegate.formSelectionDidChangeForm($scope, $result);
					}
				}
			}
		}

		formService.load(function(forms) {
			_setForms(forms);
		})

		var _writeToLocal = function(form){
			localStorage.setItem('formID', form.id);
		}

		$scope.setDelegate = function(delegate) {
			_delegate = delegate;
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
			_delegate.formSelectionDidChangeForm($scope, form);

			_writeToLocal(form);
		}


		$scope.selectType = function(type) {
			$scope.selectedType = type;
			_delegate.formSelectionDidChangeType($scope, type);
		}
	})

	.controller('ReportNavigationController', function(
		$scope, reportService, $state, ReportNavigationService
	){
		var _reportNavigationSerivce;
		var _delegate = null;
		var _dataSource = null;
		var _type = $state.params.type;

		$scope.enableClassSelector = true;
		$scope.enableRoomSelector = true;

		if (_type == 'class') {
			$scope.enableClassSelector = true;
			$scope.enableRoomSelector = false;
		} else if (_type == 'room') {
			$scope.enableClassSelector = true;
			$scope.enableRoomSelector = true;
		} else if (_type == 'school') {
			$scope.enableClassSelector = false;
			$scope.enableRoomSelector = false;
		}

		$scope.constructor = function(){
			// For shorthand
			_reportNavigationSerivce = ReportNavigationService;

			// Set this scope as current controller of the navigation
			_reportNavigationSerivce.navigationController = $scope;

			$scope.rooms 	= [];
			$scope.classes 	= [];
			$scope.room 	= null;
			$scope.class 	= null;
			$scope.currentPage = 0;

			// Call for change once for each the recently set data
			$scope.classChange();
			$scope.roomChange();
			$scope.changePage(0);
			$scope.yearChange(); 

			/*******************
			* Pagination
			*******************/
			$scope.numRows = 10;
			$scope.numPage = 0;
			$scope.totalPageCount = 0;
			$scope.pages = [];
			$scope.currentPage = 0;

			var _loadNumberOfPageIfNeeded = function(){
				if (!!!$scope.reportID || !!!$scope.year.value || !!!$scope.numRows) {
					// Either one of these not exists, do not load
					return;
				}
			}
			_loadNumberOfPageIfNeeded();
		}

		$scope.setDelegate = function(delegate) {
			_delegate = delegate
		}
		$scope.setDataSource = function(dataSource) {
			_dataSource = dataSource
		}

		$scope.reloadData = function() {
			paginationObject = _dataSource.pagesForNavigationController($scope);

			$scope.totalPageCount = paginationObject.pages.length;
			$scope.numPage = paginationObject.numberOfPageDisplay;

			if (paginationObject.pages.length > $scope.numPage) {
				$scope.pages = [];
				for (var i = 0; i < $scope.numPage; i++) {
					$scope.pages.push(i);
				}
			}
			
			$scope.classes = _dataSource.classesForNavigationController($scope);
			$scope.rooms = _dataSource.roomsForNavigationController($scope);
			$scope.years = _dataSource.yearsForNavigationController($scope);
		}

		$scope.classChange = function() {
			if (!!$scope.class && !!_delegate) {
				_delegate.navigationControllerDidChangeClass($scope, $scope.class);
			}
		}
		$scope.roomChange = function() {
			if (!!$scope.room && !!_delegate) {
				_delegate.navigationControllerDidChangeRoom($scope, $scope.room);
			}
		}
		$scope.yearChange = function() {
			if (!!$scope.year && !!_delegate) {
				_delegate.navigationControllerDidChangeYear($scope, $scope.year);
			}
		}
		$scope.selectClass = function(clazz) { $scope.class = clazz; $scope.classChange(); }
		$scope.selectRoom = function(room) { $scope.room = room; $scope.roomChange(); }
		$scope.selectYear = function(year) { $scope.year = year; $scope.yearChange(); }

		var _adjustPageToolbarWithNum = function(pageNum) {
			$scope.pages = [];
			if (pageNum == $scope.totalPageCount - 1) {
				for(var i = 0; i < $scope.numPage; i++) {
					$scope.pages.push((i + pageNum) - $scope.numPage + 1);
				}
			} else {
				for(var i = 0; i < $scope.numPage; i++) {
					$scope.pages.push(i + pageNum);
				}
			}
		}
		var _adjustPageToolbar = function(pageNum) {
			if (!!$scope.pages) {
				if ($scope.currentPage < $scope.totalPageCount &&
					$scope.currentPage > 0) {

					if (!!pageNum) {
						_adjustPageToolbarWithNum(pageNum);
					} else {
						var last = $scope.pages.length - 1;
						if ($scope.currentPage == $scope.pages[last] && last > 0) {
							var newPage = $scope.pages[last - 1] + 1;
							if (newPage < $scope.totalPageCount - 1) {
								$scope.pages.shift();
								$scope.pages.push($scope.pages[last - 1] + 1);
							}
						}
						if ($scope.currentPage == $scope.pages[0] && $scope.pages[0] != 0) {
							for (var i = $scope.pages.length - 1; i >= 0; i--) {
								$scope.pages[i]--;
							}
						}
					}
					
				} else {
					if (typeof pageNum != 'undefined') {
						_adjustPageToolbarWithNum(pageNum);
					}
				}
			}
		}

		$scope.changePage = function(page) {
			$scope.currentPage = page;
			if (!!_delegate) {
				_delegate.navigationControllerDidChangePage($scope, page);
			}
			_adjustPageToolbar();
		}
		$scope.gotoFirstPage = function() {
			$scope.changePage(0);
			_adjustPageToolbar(0);
		}
		$scope.gotoLastPage = function() {
			$scope.changePage($scope.totalPageCount-1);
			_adjustPageToolbar($scope.totalPageCount-1);
		}
		$scope.goBackwardOneSet = function() {
			var newPage = $scope.currentPage - $scope.numPage
			if (newPage < 0) newPage = 0;

			$scope.changePage(newPage);
			_adjustPageToolbar(newPage);
		}
		$scope.goForwardOneSet = function() {
			var newPage = $scope.currentPage + $scope.numPage
			if (newPage > $scope.totalPageCount) newPage = $scope.totalPageCount - 1;

			$scope.changePage(newPage);
			_adjustPageToolbar(newPage);
		}

		$scope.constructor();
	})

})();
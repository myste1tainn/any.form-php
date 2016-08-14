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

	/*
		Control form & type selection
	*/
	.controller('ReportFormSelectionController', function(
		$scope, $state, reportService, formService, ArrayHelper,
		ReportFormSelectionControllerDelegate
	){
		var _currentID = $state.params.formID || null;
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
				$result = ArrayHelper.find(_currentID, forms);
				if ($result) {
					$scope.selectedForm = form;
				}
			}
		}

		formService.load(function(forms) {
			_setForms(forms);
		})

		$scope.toggleExpand = function() {
			$scope.expanded = !$scope.expanded;
		}
		$scope.selectForm = function(form) {
			$scope.selectedForm = form;
			$scope.toggleExpand();
			$scope.delegate.onFormChange(form);
		}

		$scope.selectType = function(type) {
			$scope.selectedType = type;
			$scope.delegate.onTypeChange(type);
		}
	})

	.controller('ReportNavigationController', function(
		$scope,  formService,  reportService, $state, $class,  RISK_ID,  SDQ_ID,  EQ_ID,  $time)
	{
		var _currentID = $state.params.formID || null;
		$scope.forms 	= [];
		$scope.type 	= $state.params.type || 'person';
		$scope.form 	= $state.params.form || null;
		$scope.rooms 	= [];
		$scope.classes = [];
		$scope.room 	= null;
		$scope.class 	= null;

		var currentYear = (new Date()).getFullYear() + 543;
		var pyear = $state.params.year || currentYear;
		$scope.years = $time.years();
		$scope.year = $time.yearObjectForYear(pyear);

		if (!$scope.form) {
			$scope.form = { id: localStorage.getItem('formID') }
			formService.injectFunctions($scope.form);
		}

		$scope.classChange = function() {
			$state.go('^.overview', {
				class: $scope.class.value,
				room: $scope.room.value,
				year: $scope.year.value,
				type: $scope.type,
			})
		}
		$scope.roomChange = function() {
			$state.go('^.overview', {
				class: $scope.class.value,
				room: $scope.room.value,
				year: $scope.year.value,
				type: $scope.type,
			})
		}
		$scope.yearChange = function() {
			$state.go('^.overview', {
				class: $scope.class.value,
				room: $scope.room.value,
				year: $scope.year.value,
				type: $scope.type,
			})
		}

		/** Constructor
		 * Initial state controlling
		 */
		var components = window.location.pathname.split('/');
		var count = components.length;

		if ($state.current.name == 'report.overview' &&
			$state.url === undefined) {
			$scope.form = { id: components[count - 3] };
		}

		var createDisplayedResult = function() {
			for (var i = $scope.forms.length - 1; i >= 0; i--) {
				var f = $scope.forms[i];
				f.displayedResults = [].concat(f.results);
			};
		}

		var changeStateBlock = function() {
			var stateName = 'report.overview';
			
			if ($scope.form && !$scope.form.injectedFunctions) {
				formService.injectFunctions($scope.form);
			}

			if ($scope.form) {
				if ($scope.form.isRiskScreeningForm()) {
					stateName = 'report.risk';
				} else if ($scope.form.isSDQForm()) {
					stateName = 'report.sdq';
				} else if ($scope.form.isEQForm()) {
					stateName = 'report.eq';
				} else {
					stateName = 'report.overview';
				}

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

		/**
		 * UI Controlling part
		 */
		$scope.expanded = false;
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

		$scope.select = function(form) {
			$scope.form = form;
			$scope.selectType($scope.type);
		}

		loadClassesIfNeeded();
	})

})();
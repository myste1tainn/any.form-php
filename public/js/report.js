(function(){
	
	var module = angular.module('report', [
		'room', 'class', 'school'
	])

	.service('$report', function($http, sys){
		this.session = { activeForm: null };

		this.results = function(callback) {
			$http.get('report/results')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res);
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res);
			});
		}

		this.person = function(id, callback) {
			$http.get('report/results/'+id+'/person')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}

		this.school = function(id, callback) {
			$http.get('report/results/'+id+'/school')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}

		// this.room = function(id, callback) {
		this.room = function(id, clazz, room, callback) {
			$http.get('report/results/'+id+'/room/'+clazz+'/'+room)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}

		this.class = function(id, clazz, callback) {
			$http.get('report/results/'+id+'/class/'+clazz)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.error(res)
			});
		}
	})

	.directive('report', function($questionaire, $report, $compile, $state, $stateParams){
		return {
			restrict: 'C',
			controllerAs: 'report',
			controller: function($scope, $element, $attrs){
				var _ = this;

				console.log($stateParams);

				$scope.forms = [];
				$scope.activeType = $stateParams.type || 'person';
				$scope.activeForm = $report.session.activeForm;

				var createDisplayedResult = function() {
					for (var i = $scope.forms.length - 1; i >= 0; i--) {
						var f = $scope.forms[i];
						f.displayedResults = [].concat(f.results);
					};
				}

				$questionaire.all(function(forms) {
					$scope.forms = forms;
					createDisplayedResult();
				})

				$scope.reportChange = function(e){
					$report.session.activeForm = $scope.activeForm;
					if ($scope.activeForm) {
						changeURL();
					}
				}

				var changeURL = function() {
					$state.go('report.type', { type: $scope.activeType, form: $scope.activeForm })
				}

				$scope.personReport = function(el) {
					$scope.activeType = 'person';
					changeURL();
				}

				$scope.roomReport = function (el) {
					$scope.activeType = 'room';
					changeURL();
				}

				$scope.classReport = function (el) {
					$scope.activeType = 'class';
					changeURL();
				}

				$scope.schoolReport = function (el) {
					$scope.activeType = 'school';
					changeURL();
				}

				this.getActiveForm = function() {
					return $scope.activeForm;
				}
			}
		}
	})

	.directive('personReport', function($report, $state, $stateParams){
		return {
			restrict: 'E',
			require: '^report',
			link: function ($scope, $element, $attrs, $controller) {
				$controller.personReport = $scope;
			},
			controllerAs: 'personReport',
			templateUrl: 'report/template/person',
			controller: function($scope, $element, $attrs){
				$scope.results = [];
				$scope.displayedResults = [];

				var createDisplayedResult = function() {
					$scope.displayedResults = [].concat($scope.results);
				}

				$scope.getData = function() {
					if ($scope.activeForm !== undefined &&
					    $scope.activeForm.id !== undefined) {
						var cb = $report.person;
						cb($scope.activeForm.id, function(result){
							$scope.results = result;
						})
					}
				}

				if ($scope.activeForm) {
					$scope.getData();
				}
			}
		}
	})

})();
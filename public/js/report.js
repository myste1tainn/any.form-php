(function(){
	
	var module = angular.module('report', [
		'room', 'class', 'school'
	])

	.service('$report', function($http, sys){
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

	.directive('report', function($questionaire, $report, $compile, $route, $location){
		return {
			restrict: 'C',
			controllerAs: 'report',
			controller: function($scope, $element, $attrs){
				var _ = this;
				var _type = $route.current.params.type;

				$scope.forms = [];
				$scope.activeType = 0;
				$scope.activeForm = null;

				switch (_type) {
					case 'person': 	$scope.activeType = 0; break;
					case 'room': 	$scope.activeType = 1; break;
					case 'class': 	$scope.activeType = 2; break;
					case 'school': 	$scope.activeType = 3; break;
					default: break;
				}

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
					if ($scope.activeForm) {
						switch ($scope.activeType) {
							case 0: _.personReport.getData(); break;
							case 1: _.roomReport.getData(); break;
							case 2: _.classReport.getData(); break;
							case 3: _.schoolReport.getData(); break;
							default: break;
						}
					}
				}

				$scope.personReport = function(el) {
					$scope.activeType = 0;
				}

				$scope.roomReport = function (el) {
					$scope.activeType = 1;
				}

				$scope.classReport = function (el) {
					$scope.activeType = 2;
				}

				$scope.schoolReport = function (el) {
					$scope.activeType = 3;
				}

				this.getActiveForm = function() {
					return $scope.activeForm;
				}
			}
		}
	})

	.directive('personReport', function($report){
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
					var cb = $report.person;
					cb($scope.activeForm.id, function(result){
						$scope.results = result;
					})
				}

				if ($scope.activeForm) {
					$scope.getData();
				}
			}
		}
	})

})();
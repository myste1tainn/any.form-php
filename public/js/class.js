(function(){
	
	var module = angular.module('class', [])

	.service('$class', function($http, sys){
		var _classes = null;

		this.all = function(callback) {
			if (_classes) {
				callback(_classes);
			} else {
				$http.get('class/all')
				.success(function(res, status, headers, config){
					if (res.success) {
						_classes = res.data;
						callback(res.data);
					} else {
						sys.error(res);
					}
				})
				.error(function(res, status, headers, config){
					sys.error(res);
				});
			}
		}
	})

	.directive('classReport', function($report, $class){
		return {
			restrict: 'E',
			require: '^report',
			link: function ($scope, $element, $attrs, $controller) {
				$controller.currentTabController = $scope;
			},
			controllerAs: 'classReport',
			templateUrl: 'template/report/class',
			controller: function($scope, $element, $attrs){
				var _ = this;

				$scope.classes = [];
				$scope.class = {};

				$scope.classChange = function() {
					$scope.getData();
				}

				$scope.results = [];
				$scope.displayedResults = [];

				var createDisplayedResult = function() {
					$scope.displayedResults = [].concat($scope.results);
				}

				$scope.getData = function() {
					if ($scope.activeForm !== undefined &&
					    $scope.activeForm.id !== undefined) {
						var cb = $report.class;
						var clazz = $scope.class.value;
						cb($scope.activeForm.id, clazz, function(result){
							$scope.results = result;
						})
					}
				}

				$class.all(function(res) {
					for (var i = res.classes.length - 1; i >= 0; i--) {
						var c = res.classes[i];
						$scope.classes.push({text:c.class, value:c.class});
					};

					$scope.class = $scope.classes[0];
					
					if ($scope.activeForm) {
						$scope.getData();
					}
				})
			}
		}
	})

})();
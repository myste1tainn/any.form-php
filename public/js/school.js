(function(){
	
	var module = angular.module('school', [])

	.directive('schoolReport', function($report){
		return {
			restrict: 'E',
			require: '^report',
			link: function ($scope, $element, $attrs, $controller) {
				$controller.schoolReport = $scope;
			},
			controllerAs: 'schoolReport',
			templateUrl: 'report/template/school',
			controller: function($scope, $element, $attrs){
				var _ = this;

				$scope.schools = [];
				$scope.school = {};

				$scope.results = [];
				$scope.displayedResults = [];

				var createDisplayedResult = function() {
					$scope.displayedResults = [].concat($scope.results);
				}

				$scope.getData = function() {
					var cb = $report.school;
					var clazz = $scope.school.value;
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
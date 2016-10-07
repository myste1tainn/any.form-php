(function(){
	
	var module = angular.module('form-create-criteria', [])

	.directive('formCriteria', function($http){
		return {
			restrict: 'E',
			templateUrl: 'template/form/create-criteria',
			controller: 'FormCreateCriteriaController'
		}
	})

	.controller('FormCreateCriteriaController', function($scope){
		var copyOfPreviousCriterion = function() {
			var length = $scope.form.criteria.length;
			var previous = $scope.form.criteria[length - 1];
			var copy = angular.copy(previous);
			copy.id = -1;
			return copy;
		}

		$scope.currentCriterion = 0;
		$scope.showCriterion = function(number){
			$scope.currentCriterion = number;
		}

		$scope.addCriterion = function() {
			if ($scope.form.criteria.length > 0) {
				$scope.form.criteria.push(copyOfPreviousCriterion());
			} else {
				$scope.form.criteria.push($criterion.newInstance());
			}
			$scope.currentCriterion = $scope.form.criteria.length - 1;
		}
	})

})();
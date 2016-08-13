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
			var length = $scope.Form.criteria.length;
			var previous = $scope.Form.criteria[length - 1];
			var copy = angular.copy(previous);
			copy.id = -1;
			return copy;
		}

		$scope.currentCriterion = 0;
		$scope.showCriterion = function(number){
			$scope.currentCriterion = number;
		}

		$scope.addCriterion = function() {
			if ($scope.Form.criteria.length > 0) {
				$scope.Form.criteria.push(copyOfPreviousCriterion());
			} else {
				$scope.Form.criteria.push($criterion.newInstance());
			}
			$scope.currentCriterion = $scope.Form.criteria.length - 1;
		}
	})

})();
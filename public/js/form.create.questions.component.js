(function(){
	
	var module = angular.module('form-create-questions', [])

	.directive('formQuestions', function($http){
		return {
			restrict: 'E',
			templateUrl: 'template/form/create-questions',
			controller: 'FormCreateQuestionsController'
		}
	})

	.controller('FormCreateQuestionsController', function($scope, $element, $attrs){
		var copyOfPreviousQuestion = function() {
			var length = $scope.Form.questions.length;
			var previous = $scope.Form.questions[length - 1];
			var copy = angular.copy(previous)
			copy.id = -1;
			copy.order = parseInt(copy.order);
			copy.order += 1;
			copy.label = copy.order + ".";
			return copy;
		}

		$scope.addQuestion = function() {
			if ($scope.Form.questions.length > 0) {
				$scope.Form.questions.push(copyOfPreviousQuestion());
			} else {
				$scope.Form.questions.push($question.newInstance());
			}
			$scope.currentPage = $scope.Form.questions.length-1;
		}
	})

})();
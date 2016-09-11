(function(){
	
	var module = angular.module('form-create-choices', [])

	.directive('formChoices', function($http, $choice){
		return {
			restrict: 'E',
			templateUrl: 'template/form/create-choices',
			controllerAs: 'formChoices',
			controller: function($scope, $element, $attrs){

				var copyOfPreviousChoice = function(question) {
					var length = question.choices.length;
					var previous = question.choices[length - 1];
					var copy = angular.copy(previous);
					copy.id = -1;
					return copy;
				}

				$scope.currentPage = 0;
				$scope.showPage = function(number){
					$scope.currentPage = number;

					setTimeout(function() {
						$element.find('input[name=choice-value]').select();
					}, 0);
				}

				$scope.addChoice = function(question) {
					if (question.choices.length > 0) {
						question.choices.push(copyOfPreviousChoice(question));
					} else {
						question.choices.push($choice.newInstance());
					}
					$scope.currentPage = question.choices.length-1;

					setTimeout(function() {
						$element.find('input[name=choice-value]').select();
					}, 0);
				}

				$scope.removeCurrentChoice = function(question) {
					question.choices.splice($scope.currentPage, 1);

					if ($scope.currentPage >= question.choices.length) {
						$scope.currentPage = question.choices.length - 1;
					}
				}

			}
		}
	})

	.directive('formSubchoices', function($http, $choice){
		return {
			restrict: 'E',
			templateUrl: 'template/form/create-subchoices',
			controllerAs: 'formSubchoices',
			controller: function($scope, $element, $attrs){

				var copyOfPreviousSubchoice = function(choice) {
					var length = choice.subchoices.length;
					var previous = choice.subchoices[length - 1];
					var copy = angular.copy(previous);
					copy.id = -1;
					return copy;
				}

				$scope.addSubchoice = function(choice) {
					if (choice.subchoices === undefined) {
						choice.subchoices = [];
					}

					if (choice.subchoices.length > 0) {
						choice.subchoices.push(copyOfPreviousSubchoice(choice));
					} else {
						choice.subchoices.push($choice.newInstance());
					}
				}

			}
		}
	})

})();
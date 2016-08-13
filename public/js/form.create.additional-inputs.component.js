(function(){
	
	var module = angular.module('form-create-additional-inputs', [])

	.directive('formAdditionalInputs', function($http, $choice, $input){
		return {
			restrict: 'E',
			templateUrl: 'template/form/create-additional-inputs',
			controllerAs: 'formAdditionalInputs',
			controller: function($scope, $element, $attrs){

				var copyOfPreviousInput = function(choice) {
					var length = choice.inputs.length;
					var previous = choice.inputs[length - 1];
					var copy = angular.copy(previous);
					copy.id = -1;
					return copy;
				}

				$scope.addAdditionalInputs = function(choice) {
					if (choice.inputs === undefined) {
						choice.inputs = [];
					}

					if (choice.inputs.length > 0) {
						choice.inputs.push(copyOfPreviousInput(choice));
					} else {
						choice.inputs.push($input.newInstance());
					}
				}

				$scope.removeAdditionalInputs = function(choice) {
					if (choice.inputs.length > 0) {
						choice.inputs.pop();
					}
				}

			}
		}
	})

})();
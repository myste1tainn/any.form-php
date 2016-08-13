(function(){
	
	var module = angular.module('form-create-choice-enabled-toggler', [])

	.directive('choiceEnabledToggler', function($http){
		return {
			restrict: 'A',
			controllerAs: 'choiceEnabledToggler',
			controller: function($scope, $element, $attrs){
				$scope.toggleEnabled = function(choice) {
					if (!choice.enabled) {
						choice._cache		= angular.copy(choice);
						choice.label 		= "";
						choice.name 		= "";
						choice.description 	= "";
						choice.note 		= "";
						choice.value		= -999;
					} else {
						if (choice._cache) {
							choice.label 		= choice._cache.label;
							choice.name 		= choice._cache.name;
							choice.description 	= choice._cache.description;
							choice.note 		= choice._cache.note;
							choice.value		= choice._cache.value;
						}
					}
				}

			}
		}
	})

})();
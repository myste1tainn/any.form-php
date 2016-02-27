(function(){
	
	var module = angular.module('risk-screening', [])

	.directive('riskScreening', function($questionaire, RISK_ID){
		return {
			restrict: 'EA',
			controllerAs: 'riskScreening',
			controller: function($scope, $element, $attrs){
				$scope.screening = null;

				$questionaire.load(RISK_ID, function(questionaire){
					for (var i = questionaire.questions.length - 1; i >= 0; i--) {
						var q = questionaire.questions[i];
						q.singleSelectionType = 0;
						q.multipleSelectionType = 1;
						console.log(q.type);
					}

					$scope.screening = questionaire;
				});

			},
		}
	})

})();
(function(){
	
	var module = angular.module('form-create-question-header-toggler', [])

	.directive('questionHeaderToggler', function($question){
		return {
			restrict: 'A',
			controllerAs: 'questionHeaderToggler',
			controller: function($scope, $element, $attrs){

				$scope.toggleQuestionHeader = function(question) {
					if (question.hasHeader) {
						if (!question.meta) {
							question.meta = $question.newMeta();
						}
					} else {
						question.meta.header = null;
					}

					console.log(question.meta);
				}

				$scope.addQuestionHeaderRow = function(question) {
					var row = $question.newHeaderRow()
					question.meta.header.rows.push(row);
				}

				$scope.addQuestionHeaderCol = function(row) {
					var col = $question.newHeaderCol()
					row.cols.push(col);
				}
			}
		}
	})

})();
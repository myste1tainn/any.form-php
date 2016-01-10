(function(){
	
	var module = angular.module('questionaire', [])

	.service('$questionaire', function($http, $question, $criterion) {
		this.newInstance = function() {
			return {
				id: -1,
				name: "แบบฟอร์มใหม่",
				criteria: [$criterion.newInstance()],
				questions: [$question.newInstance()]
			}
		}
	})

	.controller('QuestionaireListController', function($scope){
		$scope.questionaires = [
			{ id: 1, name: 'แบบฟอร์ม 1' },
			{ id: 2, name: 'แบบฟอร์ม 2' },
			{ id: 3, name: 'แบบฟอร์ม 3' },
			{ id: 4, name: 'แบบฟอร์ม 4' },
			{ id: 1, name: 'แบบฟอร์ม 1' },
			{ id: 2, name: 'แบบฟอร์ม 2' },
			{ id: 3, name: 'แบบฟอร์ม 3' },
			{ id: 4, name: 'แบบฟอร์ม 4' },
		]
	})

	.controller('QuestionaireCreateController', function(
		$scope, $questionaire, $question, $criterion, $choice
	) {
		$scope.questionaire = $questionaire.newInstance();

		console.log($scope.questionaire);

		$scope.submit = function() {
			$questionaire.save($scope.questionaire);
		}

		$scope.addCriterion = function() {
			$scope.questionaire.criteria.push($criterion.newInstance());
		}

		$scope.addQuestion = function() {
			$scope.questionaire.questions.push($question.newInstance());
		}

		$scope.addChoice = function(question) {
			question.choices.push($choice.newInstance());
		}
	});

})();
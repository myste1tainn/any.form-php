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

		this.save = function(questionaire) {
			return $http.post('form/save', questionaire);
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
		$scope, ngDialog,
		$questionaire, $question, $criterion, $choice
	) {
		$scope.questionaire = $questionaire.newInstance();

		$scope.submit = function() {
			$questionaire.save($scope.questionaire)
			.success(function(res, status, headers, config){
				ngDialog.open({
					plain: true,
					template: (res.message) ? res.message : res
				})
			})
			.error(function(res, status, headers, config){
				console.log(res, status, headers);
				ngDialog.open({
					plain: true,
					template: res
				})
			});
		}

		var copyOfPreviousCriterion = function() {
			var length = $scope.questionaire.criteria.length;
			var previous = $scope.questionaire.criteria[length - 1];
			return angular.copy(previous);
		}

		var copyOfPreviousQuestion = function() {
			var length = $scope.questionaire.questions.length;
			var previous = $scope.questionaire.questions[length - 1];
			return angular.copy(previous);
		}

		var copyOfPreviousChoice = function(question) {
			var length = question.choices.length;
			var previous = question.choices[length - 1];
			return angular.copy(previous);
		}

		$scope.addCriterion = function() {
			if ($scope.questionaire.criteria.length > 0) {
				$scope.questionaire.criteria.push(copyOfPreviousCriterion());
			} else {
				$scope.questionaire.criteria.push($criterion.newInstance());
			}
		}

		$scope.addQuestion = function() {
			if ($scope.questionaire.questions.length > 0) {
				console.log('copy');
				$scope.questionaire.questions.push(copyOfPreviousQuestion());
			} else {
				$scope.questionaire.questions.push($question.newInstance());
			}
		}

		$scope.addChoice = function(question) {
			if (question.choices.length > 0) {
				question.choices.push(copyOfPreviousChoice(question));
			} else {
				question.choices.push($choice.newInstance());
			}
		}
	});

})();
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

		this.load = function(id, callback) {
			if (typeof id != 'undefined') {
				$http.get('api/questionaire/'+id)
				.success(function(res, status, headers, config){
					callback(res);
				})
				.error(function(res, status, headers, config){
					callback(this.newInstance());
				});
			} else {
				callback(this.newInstance());
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
		$scope, $route, ngDialog,
		$questionaire, $question, $criterion, $choice
	) {
		var id = $route.current.params.questionaireID
		
		$questionaire.load(id, function(questionaire) {
			console.log(questionaire)
			$scope.questionaire = questionaire;
		})

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
			var copy = angular.copy(previous);
			return copy;
		}

		var copyOfPreviousQuestion = function() {
			var length = $scope.questionaire.questions.length;
			var previous = $scope.questionaire.questions[length - 1];
			var copy = angular.copy(previous)
			copy.id = -1;
			copy.order += 1;
			copy.label = copy.order + ".";
			return copy;
		}

		var copyOfPreviousChoice = function(question) {
			var length = question.choices.length;
			var previous = question.choices[length - 1];
			var copy = angular.copy(previous);
			copy.id = -1;
			return copy;
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

		$scope.toggleFold = function (question) {
			if (typeof question.folded == 'undefined') {
				question.folded = true;
			} else {
				question.folded = !question.folded;
			}
		}
	});

})();
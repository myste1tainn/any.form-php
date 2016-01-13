(function(){
	
	var module = angular.module('questionaire', [])

	.service('$questionaire', function($http, $question, $criterion, ngDialog) {
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

		this.all = function(callback) {
			$http.get('api/questionaires')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					ngDialog.open({
						plain: true,
						template: res
					});	
				}
			})
			.error(function(res, status, headers, config){
				ngDialog.open({
					plain: true,
					template: res
				});
			});
		}

		this.save = function(questionaire) {
			return $http.post('form/save', questionaire);
		}

		this.submit = function(result, callback) {
			$http.post('api/questionaire/submit', result)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.message)
				} else {
					ngDialog.open({
						plain: true,
						template: res
					})
				}
			})
			.error(function(res, status, headers, config){
				ngDialog.open({
					plain: true,
					template: res
				})
			});
		}
	})

	.controller('QuestionaireListController', function($scope, $questionaire, ngDialog){
		$scope.questionaires = [];
		$questionaire.all(function(questionaires){
			$scope.questionaires = questionaires;
		})
	})

	.controller('QuestionaireCreateController', function(
		$scope, $route, ngDialog,
		$questionaire, $question, $criterion, $choice
	) {
		var id = $route.current.params.questionaireID
		
		$questionaire.load(id, function(questionaire) {
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
	})

	.controller('QuestionaireDoController', function($scope, $route, $questionaire, ngDialog) {
		var id = $route.current.params.questionaireID

		$scope.participant = { 
			identifier: null, 
			choices: []
		};
		$scope.questionaire = {};
		$questionaire.load(id, function(questionaire){
			$scope.questionaire = questionaire;
		})

		$scope.toggleChoose = function(question, choice) {
			question.choice = choice;
		}

		$scope.isChoosen = function(question, choice) {
			return question.choice == choice;
		}

		var choosenChoices = function() {
			var choices = [];
			for (var i = 0; i < $scope.questionaire.questions.length; i++) {
				var q = $scope.questionaire.questions[i];
				
				if (q.choice) {
					choices.push(q.choice);
				}
			};
			return choices;
		}

		var validateFormInput = function() {
			var valid = (
						$scope.participant.identifier != null && 
						$scope.participant.identifier != ""
						);

			if (!valid) {
				ngDialog.open({
					plain: true,
					template: 'กรุณาใส่หมายเลขประจำตัวนักเรียน'
				});
			}

			return valid;
		}

		var validateChoosenChoices = function(choices) {
			var valid = choices.length == $scope.questionaire.questions.length;

			console.log(choices);

			if (!valid) {
				ngDialog.open({
					plain: true,
					template: 'กรุณาตอบคำถามให้ครบทุกข้อ'
				})
			}

			return valid;
		}

		$scope.submit = function() {
			var choices = choosenChoices();

			// if (validateFormInput()) {
			// 	if (validateChoosenChoices(choices)) {
					$scope.participant.choices = choices;
					$scope.participant.questionaireID = $scope.questionaire.id;

					$questionaire.submit($scope.participant, function (response) {
						ngDialog.open({
							plain: true,
							template: response
						})
					})
					
				// }	
			// }
		}
	})

})();
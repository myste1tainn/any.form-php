(function(){
	
	var module = angular.module('risk-screening', [])

	.directive('riskScreening', function($questionaire, $participant, $answer, $stateParams, 
	                                     ngDialog, RISK_ID, ACADEMIC_YEAR){
		return {
			restrict: 'EA',
			controllerAs: 'riskScreening',
			link: function($scope) {
				// Wait for the participantInfo directive to run fist
				// so that we can call mockupInput()
				$scope.mockupInput();
			},
			controller: function($scope, $element, $attrs){
				$scope.screening = null;

				// Find out if the specify choice existed in answers
				var choiceExistsInAnswers = function(c, ans) {
					for (var i = ans.length - 1; i >= 0; i--) {
						var a = ans[i];
						if (a.choiceID == c.id) {

							if (c.inputs) {
								if (c.inputs.length > 0) {
									for (var j = c.inputs.length - 1; j >= 0; j--) {
										var input = c.inputs[j];
										input.value = a.inputs[j].value;
									}
								}
							}

							return true;
						}
					}

					return false;
				}

				// Match between answers and questions
				// To create answered questions matrix
				// qq is questionaire, aa is answers
				var createAnsweredQuestionMatrix = function (qq, aa) {
					for (var i = qq.questions.length - 1; i >= 0; i--) {
						var q = qq.questions[i];
						if (q.type == 0) {
							for (var j = q.choices.length - 1; j >= 0; j--) {
								var c = q.choices[j];
								if (choiceExistsInAnswers(c, aa)) {
									q.selected = c;
								}
							}
						} else {
							for (var j = q.choices.length - 1; j >= 0; j--) {
								var c = q.choices[j];
								if (choiceExistsInAnswers(c, aa)) {
									c.checked = true;
								}
								
								for (var k = c.subchoices.length - 1; k >= 0; k--) {
									var sc = c.subchoices[k];
									if (choiceExistsInAnswers(sc, aa)) {
										sc.checked = true
									}
								}
							}
						}
					}
				}

				// Load the questionaire questions
				$questionaire.load(RISK_ID, function(questionaire){
					$scope.screening = questionaire;

					if ($stateParams.studentID) {
						$participant.load($stateParams.studentID, function(participant){
							participant.identifier = parseInt(participant.identifier);
							$scope.participant = participant;
						})

						$answer.load(RISK_ID, $stateParams.year, $stateParams.studentID, function(answers) {
							createAnsweredQuestionMatrix(questionaire, answers)
						});
					}
				});

				var choiceHasNoSubchoicesChecked = function (c) {
					for (var i = c.subchoices.length - 1; i >= 0; i--) {
						sc = c.subchoices[i];
						if (sc.checked) {
							return false;
						} 
					}
					return true;
				}

				var uncheckAllSubchoices = function(c) {
					for (var i = c.subchoices.length - 1; i >= 0; i--) {
						c.subchoices[i].checked = false;
					}
				}

				var putToArrayIfChecked = function(arr, item) {
					if (item.checked) {
						arr.push(item);
					}
				}

				var choosenChoices = function() {
					var choices = [];
					for (var i = $scope.screening.questions.length - 1; i >= 0; i--) {
						var q = $scope.screening.questions[i];

						if (q.type == 0) {
							// Type == 0, allow selection only 1 choice per question
							// Add the selected to choosenChoices
							choices.push(q.selected);
						} else {
							// Type != 0, allow multiple selection per question
							// Add checked choices & subchoices to choosenChoices
							for (var j = q.choices.length - 1; j >= 0; j--) {
								var c = q.choices[j];
								putToArrayIfChecked(choices, c);
								for (var k = c.subchoices.length - 1; k >= 0; k--) {
									var sc = c.subchoices[k];
									putToArrayIfChecked(choices, sc);
								}
							}
						}
					}
					return choices;
				}

				$scope.checkChoice = function(c) {
					if (!c.checked) {
						uncheckAllSubchoices(c);		
					}
				}

				$scope.checkSubchoice = function(sc, c) {
					c.checked = !choiceHasNoSubchoicesChecked(c);
				}

				$scope.toggleCheck = function(sc, c) {
					sc.checked = !sc.checked;
					$scope.checkSubchoice(sc, c);
				}

				$scope.submit = function() {
					var choices = choosenChoices();

					if ($scope.validateFormInput()) {
						$scope.participant.choices = choices;
						$scope.participant.questionaireID = $scope.screening.id;

						$questionaire.submit($scope.participant, function (response) {
							ngDialog.open({
								plain: true,
								template: response
							})
						})
					}
				}
			},
		}
	})

})();
(function(){
	
	var module = angular.module('form-do', ['form-service'])

	.controller('FormDoController', function($scope, $stateParams, formService, ngDialog){
		var _isSDQReports = false;
		var id = $stateParams.formID;
		$scope.form = $stateParams.form;

		var initializeForm = function(){
			for (var i = $scope.form.questions.length - 1; i >= 0; i--) {
				var q = $scope.form.questions[i];
				q.choosenChoices = [];

				if (q.type == 4) {
					for (var j = q.choices.length - 1; j >= 0; j--) {
						var c = q.choices[j];
						c.choosenChoices = [];
					}
				}

				if (!!q.meta) {
					if (!!q.meta.header) {
						try {
							q.meta.header = JSON.parse(q.meta.header);
						} catch (e) {

						}
					}
				}
			}

			if (typeof $scope.form.header == 'string') {
				$scope.form.header = JSON.parse($scope.form.header);
			}
		}

		var loadFormIfNeeded = function(){
			if (!!!$scope.form) {
				formService.load(id, function(form){
					$scope.form = form;
					initializeForm();
				})
			} else {
				initializeForm();
			}
		}
		loadFormIfNeeded();
		
		formService.isSDQReport(id).then(function(res) {
			_isSDQReports = res;
		})

		$scope.toggleChoose = function(question, choice) {
			if (choice.enabled) {
				var index = question.choosenChoices.indexOf(choice);
				if (index > -1) {
					question.choosenChoices.splice(index, 1);
				} else {
					// The less than zero are question that allows multiple selection
					// and not type 4
					if (question.type > -1) {
						// This is choose-one question reset choices before push anew
						question.choosenChoices = [];
					}
					question.choosenChoices.push(choice);

					if (_isSDQReports && question.order == 27 && choice.name.indexOf('ไม่') > -1) {
						// select the rest answers automactically
						for (var i = $scope.form.questions.length - 1; i >= 0; i--) {
							var q = $scope.form.questions[i];
							if (q.order == 32) {
								for (var j = q.choices.length - 1; j >= 0; j--) {
									var c = q.choices[j];
									var cc = c.subchoices[0];
									$scope.toggleChoose(c, cc);
								}
							} else if (q.order > 27) {
								if (q.choices.length > 1) {
									var c = q.choices[0];
									$scope.toggleChoose(q, c);
								}
							}
						}
					}
				}
			}
		}

		$scope.isChoosen = function(question, choice) {
			return question.choosenChoices.indexOf(choice) > -1;
		}

		var choosenChoices = function() {
			var choices = [];
			for (var i = 0; i < $scope.form.questions.length; i++) {
				var q = $scope.form.questions[i];
				
				if (q.type == 4) {
					for (var j = q.choices.length - 1; j >= 0; j--) {
						var c = q.choices[j];
						for (var k = c.choosenChoices.length - 1; k >= 0; k--) {
							var sc = c.choosenChoices[k];
							choices.push(sc);
						}
					}
				} else {
					if (q.type == 1) {

						choices.push(q.choices[0]);

					} else {
						for (var j = q.choosenChoices.length - 1; j >= 0; j--) {
							var c = q.choosenChoices[j];
							choices.push(c);
						}
					}
				}
			};
			return choices;
		}

		var totalLength = function(){
			var baseLength = $scope.form.questions.length;

			for (var i = $scope.form.questions.length - 1; i >= 0; i--) {
				var q = $scope.form.questions[i];

				if (q.type == 1 || // Question of custom inputs is not count
					q.type == 2 // Not really a question, just a description text
					) {
					baseLength--;
				}

				// It is a question of choice with subchoices while the choice it self does not count
				// Count the subchoices as need-to-be-answered question
				if (q.type == 4) {
					baseLength--; // Doesn't count the question itself

					// Count it choices instead
					baseLength += q.choices.length;
				}
			}

			return baseLength;
		}

		var validateChoosenChoices = function(choices) {
			var valid = choices.length >= totalLength();
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
			if ($scope.validateFormInput()) {
				if (validateChoosenChoices(choices)) {
					$scope.participant.choices = choices;
					$scope.participant.formID = $scope.form.id;

					formService.submit($scope.participant, function (response) {
						alert(response.message);
					})
					
				}	
			}
		}
	})

})();
(function(){
	
	var module = angular.module('questionaire', ['risk-screening'])

	.service('$input', function() {
		this.newInstance = function() {
			return {
				id: -1,
				name: "New Input",
				placeholder: "New Input Placeholder",
				type: 0,
			}
		}
	})

	.service('$answer', function($http, req, sys) {
		this.load = function(questionaireID, academicYear, participantID, callback) {
			var url = 'api/answers/'+questionaireID+'/'+academicYear+'/'+participantID;
			req.getData(url, callback);
		}
	})

	.service('$questionaire', function($http, $question, $criterion, ngDialog, req, sys) {
		this.newInstance = function() {
			return {
				id: -1,
				name: "แบบฟอร์มใหม่",
				criteria: [$criterion.newInstance()],
				questions: [$question.newInstance()],
				type: 0,
				level: 0
			}
		}

		this.newHeader = function() {
			return {
				rows: [this.newHeaderRow()]
			}
		}

		this.newHeaderRow = function () {
			return {
				cols: [this.newHeaderCol()]
			}
		}

		this.newHeaderCol = function () {
			return {
				rowspan: 1, colspan: 1, label: 'New Label'
			}
		}

		this.load = function(id, callback) {
			if (typeof id != 'undefined' && id != null) {
				$http.get('api/questionaire/'+id)
				.success(function(res, status, headers, config){
					if (typeof res == 'object') {
						if (res.header != null) {
							res.header = JSON.parse(res.header);

							if (typeof res.header == 'string') {
								res.header = JSON.parse(res.header);
							}
						}

						for (var i = res.questions.length - 1; i >= 0; i--) {
							var q = res.questions[i];
							if (q.meta) q.meta.header = JSON.parse(q.meta.header);
						};
						callback(res);
					} else {
						sys.dialog.error(res);
					}
				})
				.error(function(res, status, headers, config){
					callback(this.newInstance());
				});
			} else {
				callback(this.newInstance());
			}
		}

		this.all = function(callback) {
			req.getData('api/questionaires', callback)
		}

		this.save = function(questionaire, callback) {
			req.postData('form/save', questionaire, callback);
		}

		this.submit = function(result, callback) {
			req.postMessage('api/questionaire/submit', result, callback);
		}
	})

	.service('$participant', function($http, req) {
		this.load = function(id, callback) {
			req.getData('api/participant/'+id, callback);
		}
	})

	.controller('QuestionaireListController', function($scope, $questionaire, ngDialog, RISK_ID){
		$scope.questionaires = [];
		$questionaire.all(function(questionaires){
			$scope.questionaires = questionaires;
		})

		this.isNotRisk = function(form) {
			return form.id != RISK_ID;
		}
	})

	.directive('questionaireCreate', function($stateParams, ngDialog, $questionaire){
		return {
			restrict: 'E',
			controllerAs: 'questionaireCreate',
			controller: function($scope, $element, $attrs){
				var id = $stateParams.formID

				$scope.currentPage = null;

				$scope.showPage = function(number){
					$scope.currentPage = number;
				}

				$questionaire.load(id, function(questionaire) {
					$scope.questionaire = questionaire;

					if ($scope.questionaire.header) {
						$scope.toggleHasHeader(true, true);
					}

					if ($scope.questionaire.questions.length > 0) {
						$scope.currentPage = 0;
					}
				})

				var compileHeader = function() {
					if ($scope.hasHeader()) {
						
					} else {
						$scope.questionaire.header = null;
					}
				}

				$scope.submit = function() {
					compileHeader();
					$questionaire.save($scope.questionaire, function(data) {
						$scope.questionaire = data;
					})
				}

				$scope.toggleFold = function (question) {
					if (typeof question.folded == 'undefined') {
						question.folded = true;
					} else {
						question.folded = !question.folded;
					}
				}
			}
		}
	})

	.directive('questionaireInfo', function($http){
		return {
			restrict: 'E',
			require: '^questionaireCreate',
			link: function($scope, $element, $attrs, $controller) {
				// For the purpose of scope linking assurance
			},
			templateUrl: 'template/questionaire/create/info',
			controllerAs: 'questionaireBody',
			controller: function($scope, $element, $attrs){
				
			}
		}
	})

	.directive('questionaireCriteria', function($http, $criterion){
		return {
			restrict: 'E',
			require: '^questionaireCreate',
			link: function($scope, $element, $attrs, $controller) {
				// For the purpose of scope linking assurance
			},
			templateUrl: 'template/questionaire/create/criteria',
			controllerAs: 'questionaireCriteria',
			controller: function($scope, $element, $attrs){
				var copyOfPreviousCriterion = function() {
					var length = $scope.questionaire.criteria.length;
					var previous = $scope.questionaire.criteria[length - 1];
					var copy = angular.copy(previous);
					copy.id = -1;
					return copy;
				}

				$scope.currentCriterion = 0;
				$scope.showCriterion = function(number){
					$scope.currentCriterion = number;
				}

				$scope.addCriterion = function() {
					if ($scope.questionaire.criteria.length > 0) {
						$scope.questionaire.criteria.push(copyOfPreviousCriterion());
					} else {
						$scope.questionaire.criteria.push($criterion.newInstance());
					}
					$scope.currentCriterion = $scope.questionaire.criteria.length - 1;
				}
			}
		}
	})

	.directive('questionaireQuestions', function($http, $question){
		return {
			restrict: 'E',
			require: '^questionaireCreate',
			link: function($scope, $element, $attrs, $controller) {
				// For the purpose of scope linking assurance
			},
			templateUrl: 'template/questionaire/create/questions',
			controllerAs: 'questionaireQuestions',
			controller: function($scope, $element, $attrs){

				var copyOfPreviousQuestion = function() {
					var length = $scope.questionaire.questions.length;
					var previous = $scope.questionaire.questions[length - 1];
					var copy = angular.copy(previous)
					copy.id = -1;
					copy.order = parseInt(copy.order);
					copy.order += 1;
					copy.label = copy.order + ".";
					return copy;
				}

				$scope.addQuestion = function() {
					if ($scope.questionaire.questions.length > 0) {
						$scope.questionaire.questions.push(copyOfPreviousQuestion());
					} else {
						$scope.questionaire.questions.push($question.newInstance());
					}
					$scope.currentPage = $scope.questionaire.questions.length-1;
				}

			}
		}
	})

	.directive('questionaireChoices', function($http, $choice){
		return {
			restrict: 'E',
			require: '^questionaireCreate',
			link: function($scope, $element, $attrs, $controller) {
				// For the purpose of scope linking assurance
			},
			templateUrl: 'template/questionaire/create/choices',
			controllerAs: 'questionaireChoices',
			controller: function($scope, $element, $attrs){

				var copyOfPreviousChoice = function(question) {
					var length = question.choices.length;
					var previous = question.choices[length - 1];
					var copy = angular.copy(previous);
					copy.id = -1;
					return copy;
				}

				$scope.currentPage = 0;
				$scope.showPage = function(number){
					
					$scope.currentPage = number;
				}

				$scope.addChoice = function(question) {
					if (question.choices.length > 0) {
						question.choices.push(copyOfPreviousChoice(question));
					} else {
						question.choices.push($choice.newInstance());
					}
					$scope.currentPage = question.choices.length-1;
				}

				$scope.removeCurrentChoice = function(question) {
					question.choices.splice($scope.currentPage, 1);

					if ($scope.currentPage >= question.choices.length) {
						$scope.currentPage = question.choices.length - 1;
					}
				}

			}
		}
	})

	.directive('questionaireSubchoices', function($http, $choice){
		return {
			restrict: 'E',
			require: '^questionaireCreate',
			link: function($scope, $element, $attrs, $controller) {
				// For the purpose of scope linking assurance
			},
			templateUrl: 'template/questionaire/create/subchoices',
			controllerAs: 'questionaireSubchoices',
			controller: function($scope, $element, $attrs){

				var copyOfPreviousSubchoice = function(choice) {
					var length = choice.subchoices.length;
					var previous = choice.subchoices[length - 1];
					var copy = angular.copy(previous);
					copy.id = -1;
					return copy;
				}

				$scope.addSubchoice = function(choice) {
					if (choice.subchoices === undefined) {
						choice.subchoices = [];
					}

					if (choice.subchoices.length > 0) {
						choice.subchoices.push(copyOfPreviousSubchoice(choice));
					} else {
						choice.subchoices.push($choice.newInstance());
					}
				}

			}
		}
	})

	.directive('questionaireAdditionalInputs', function($http, $choice, $input){
		return {
			restrict: 'E',
			require: '^questionaireCreate',
			link: function($scope, $element, $attrs, $controller) {
				// For the purpose of scope linking assurance
			},
			templateUrl: 'template/questionaire/create/additional-inputs',
			controllerAs: 'questionaireAdditionalInputs',
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

	.directive('participantInfo', function($http, ngDialog){
		return {
			restrict: 'EA',
			controllerAs: 'participantInfo',
			controller: function($scope, $element, $attrs){
				$scope.participant = { 
					identifier: null, 
					choices: []
				};

				$scope.validateFormInput = function() {
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

				$scope.mockupInput = function() {
					$scope.participant.identifier = 22611;
					$scope.participant.firstname = "อานนท์";
					$scope.participant.lastname = "คีรีนะ";
					$scope.participant.class = 6;
					$scope.participant.room = 4;
					$scope.participant.number = 26;
				}

				$scope.mockupInput();
			}
		}
	})

	.controller('QuestionaireDoController', function($scope, $stateParams, $questionaire, ngDialog, RISK_ID) {
		var id = $stateParams.formID

		$scope.questionaire = {};
		$questionaire.load(id, function(questionaire){
			for (var i = questionaire.questions.length - 1; i >= 0; i--) {
				var q = questionaire.questions[i];
				q.choosenChoices = [];

				if (q.type == 4) {
					for (var j = q.choices.length - 1; j >= 0; j--) {
						var c = q.choices[j];
						c.choosenChoices = [];
					}
				}
			}

			$scope.questionaire = questionaire;
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
				}
			}
		}

		$scope.isChoosen = function(question, choice) {
			return question.choosenChoices.indexOf(choice) > -1;
		}

		var choosenChoices = function() {
			var choices = [];
			for (var i = 0; i < $scope.questionaire.questions.length; i++) {
				var q = $scope.questionaire.questions[i];
				
				if (q.type == 4) {
					for (var j = q.choices.length - 1; j >= 0; j--) {
						var c = q.choices[j];
						for (var k = c.choosenChoices.length - 1; k >= 0; k--) {
							var sc = c.choosenChoices[k];
							choices.push(sc);
						}
					}
				} else {
					for (var j = q.choosenChoices.length - 1; j >= 0; j--) {
						var c = q.choosenChoices[j];
						choices.push(c);
					}
				}
			};
			return choices;
		}

		var totalLength = function(){
			var baseLength = $scope.questionaire.questions.length;

			for (var i = $scope.questionaire.questions.length - 1; i >= 0; i--) {
				var q = $scope.questionaire.questions[i];

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
			console.log(choices.length);
			var valid = choices.length == totalLength();

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
					$scope.participant.questionaireID = $scope.questionaire.id;

					$questionaire.submit($scope.participant, function (response) {
						ngDialog.open({
							plain: true,
							template: response
						})
					})
					
				}	
			}
		}
	})

	.directive('headerToggler', function($http, $questionaire){
		return {
			restrict: 'A',
			require: 'questionaireCreate',
			controllerAs: 'headerToggler',
			controller: function($scope, $element, $attrs){
				var _hasHeader = false;

				$scope.toggleHasHeader = function(val, relectToElement) {
					_hasHeader = val;

					if (_hasHeader) {
						if ($scope.questionaire.header) {

						} else {
							$scope.questionaire.header = $questionaire.newHeader();
						}
					};

					if (relectToElement) {
						$element.prop('checked', val);
					}
				}

				$scope.hasHeader = function() {
					return _hasHeader;
				}

				$scope.addHeaderRow = function() {
					var row = $questionaire.newHeaderRow();
					$scope.questionaire.header.rows.push(row);
				}

				$scope.addHeaderCol = function(row) {
					var col = $questionaire.newHeaderCol()
					row.cols.push(col);
				}

				$element.change(function (e) {
					$scope.toggleHasHeader($element.prop('checked'));
					$scope.$apply();
				})
			}
		}
	})

	.directive('choiceEnabledToggler', function($http){
		return {
			restrict: 'A',
			require: 'questionaireCreate',
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
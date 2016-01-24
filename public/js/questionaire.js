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
			if (typeof id != 'undefined') {
				$http.get('api/questionaire/'+id)
				.success(function(res, status, headers, config){
					if (typeof res == 'object') {
						if (res.header != null) {
							var h = res.header;
							res.header = JSON.parse(h);
						}

						for (var i = res.questions.length - 1; i >= 0; i--) {
							var q = res.questions[i];
							if (q.meta) q.meta.header = JSON.parse(q.meta.header);
						};
						callback(res);
					} else {
						ngDialog.open({
							plain: true,
							template: res
						})
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

	.directive('questionaireCreate', function(
		$route, ngDialog,
		$questionaire, $question, $criterion, $choice
	){
		return {
			restrict: 'E',
			controllerAs: 'questionaireCreate',
			controller: function($scope, $element, $attrs){
				var id = $route.current.params.questionaireID

				$questionaire.load(id, function(questionaire) {
					$scope.questionaire = questionaire;

					if ($scope.questionaire.header) {
						$scope.toggleHasHeader(true, true);
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
					copy.id = -1;
					return copy;
				}

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
			if (choice.enabled) {
				question.choice = choice;
			}
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

			if (validateFormInput()) {
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
					var row = $questionaire.newHeaderRow()
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
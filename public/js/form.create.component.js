(function(){
	
	var module = angular.module('form-create', [
		'form-create-criteria', 'form-create-questions', 'form-create-choices',
		'form-create-header-toggler', 'form-create-question-header-toggler', 'form-create-choice-enabled-toggler',
		'form-create-additional-inputs'
	])

	.directive('formInfo', function($http){
		return {
			restrict: 'E',
			templateUrl: 'template/form/create-info'
		}
	})

	.controller('FormCreateController', function($scope, $element, $stateParams, formService, ngDialog){
		var id = $stateParams.formID

		$scope.currentPage = null;

		$scope.showPage = function(number){
			$scope.currentPage = number;

			setTimeout(function() {
				$element.find('input[name=question-name]').select();
			}, 0);
		}

		var checkFormHeader = function() {
			if ($scope.form.header) {
				if (typeof $scope.form.header == 'string') {
					$scope.form.header = JSON.parse($scope.form.header);
				}
				$scope.toggleHasHeader(true, true);
			}
		}

		var loadFormIfNeeded = function(){
			if (!!!id) {
				$scope.form = formService.newInstance();
				return;
			}
			formService.load(id, function(form) {
				$scope.form = form;
				if ($scope.form.questions.length > 0) {
					$scope.currentPage = 0;
				}
				checkFormHeader();
			})
		}
		loadFormIfNeeded();

		var compileHeader = function() {
			if ($scope.hasHeader()) {
				
			} else {
				$scope.form.header = null;
			}
		}

		$scope.submit = function() {
			compileHeader();
			formService.save($scope.form, function(data) {
				alert(data.message);
				$scope.form = data.results;
				checkFormHeader();
			})
		}

		$scope.toggleFold = function (question) {
			if (typeof question.folded == 'undefined') {
				question.folded = true;
			} else {
				question.folded = !question.folded;
			}
		}
	})

})();
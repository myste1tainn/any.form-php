(function(){
	
	var module = angular.module('question', [])

	.service('$question', function($choice){
		this.newInstance = function() {
			return {
				id: -1,
				order: 1,
				label: "1.",
				name: "คำถามใหม่",
				description: "",
				choices: [$choice.newInstance()],
				type: 0,
				choiceAsHeader: false,
				folded: true,
				meta: this.newMeta()
			}
		}

		this.newMeta = function() {
			return {
				id : -1,
				header: this.newHeader()
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
	})

	.directive('formSelect', function(formService, $state){
		return {
			restrict: 'E',
			templateUrl: 'template/form-select',
			controllerAs: 'nav',
			controller: function($scope, $element){
				var _this = this;

				var _changeState = function() {
					$state.go('question-grouping.show', {
						form:_this.form, 
						formID:_this.form.id
					})
				}

				formService.load(function(forms) {
					_this.forms = forms;
					// if (forms.length > 0) {
					// 	_this.select(forms[0]);
					// }
				})

				/**
				 * UI Controlling part
				 */
				this.expanded = false;
				this.toggleExpand = function() {
					this.expanded = !this.expanded;
					if (this.expanded) {
						setTimeout(function() {
							angular.element('body').click(function(){
								$scope.$apply(function(){
									_this.expanded = false;
									angular.element('body').off();
								});
							})
						}, 10);
					} else {
						angular.element('body').off();
					}
				}

				this.select = function(form) {
					this.form = form;
					_changeState();
				}
			}
		}
	})

	.controller('QuestionGroupController', function($scope, $element, $state){
		this.formID = $state.params.formID;
	})

	.controller('GroupFormController', function($scope, $element, $state, Groups){
		var _formID = $state.params.formID || null;
		$scope.selectedGroupID = $state.params.groupID || null;
		$scope.group = {};
		$scope.addGroup = function(group) {
			Groups.insert({
				name: group.name,
				formID: _formID
			}).then(function(res){
				setTimeout(function() { $element.find('input').select() }, 0);
			})
			$scope.group = {};
		}
	})

	.controller('GroupListController', function($scope, $state, Groups){
		var _form = $state.params.form || null;
		var _group = $state.params.group || null;
		var _formID = $state.params.formID || null;
		var _groupID = $state.params.groupID || null;
		$scope.currentGroup = null;
		$scope.selectedGroupID = _groupID;
		$scope.groups = Groups.all(_formID);

		$scope.isSelected = function(group) {
			return group.id == $scope.selectedGroupID;
		}

		$scope.selectGroup = function(group){
			$scope.currentGroup = group;
			$state.go('question-grouping.show', {
				group: $scope.currentGroup,
				groupID: $scope.currentGroup.id,
				form: _form,
				formID: _formID
			});
		}
		$scope.removeGroup = function(group){
			Groups.remove(group);
		}

		$scope.beginEditGroup = function(group){
			group.editLabel = true;
		}

		$scope.updateGroup = function(group){
			Groups.update(group);
			group.editLabel = false;
		}
	})

	.controller('QuestionListController', function($scope, $state, Questions){
		var _form = $state.params.form || null;
		var _group = $state.params.group || null;
		var _formID = $state.params.formID || null;
		var _groupID = $state.params.groupID || null;

		$scope.questions = Questions.all(_formID);
	})

	.controller('QuestionMapListController', function($scope, $state, Questions){
		var _form = $state.params.form || null;
		var _group = $state.params.group || null;
		var _formID = $state.params.formID || null;
		var _groupID = $state.params.groupID || null;

		$scope.questions = Questions.all(_formID);
		$scope.selectQuestion = function(question){
			var parameterGroupID = null;
			if (question.groupID == _groupID) {
				// Deselect out of group
				parameterGroupID = null;
			} else {
				// Select into group
				parameterGroupID = _groupID;
			}

			Questions.update({
				id: question.id,
				groupID: parameterGroupID
			})

			// Assume success
			question.groupID = parameterGroupID;
		}
	})
	
	.directive('groupForm', function(){
		return {
			scope: true,
			restrict: 'E',
			templateUrl: 'template/question/group-form',
			controllerAs: 'groupForm',
			controller: 'GroupFormController'
		}
	})

	.directive('groupList', function($http){
		return {
			scope: true,
			restrict: 'E',
			templateUrl: 'template/question/group-list',
			controllerAs: 'groupList',
			controller: 'GroupListController'
		}
	})

	.directive('questionList', function(){
		return {
			scope: true,
			restrict: 'E',
			templateUrl: 'template/question/list',
			controllerAs: 'questionList',
			controller: 'QuestionListController'
		}
	})

	.directive('questionMapList', function(){
		return {
			scope: true,
			restrict: 'E',
			templateUrl: 'template/question/list',
			controllerAs: 'questionMapList',
			controller: 'QuestionMapListController'
		}
	})

})();
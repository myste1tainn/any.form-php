(function(){
	
	var module = angular.module('question', [])

	.service('Questions', function($http, ArrayHelper){
		var _collections = [];
		var _subscribers = [];

		var _getCollections = function(id) {
			var _success = function(res, status, headers, config){
				_collections.splice(0, _collections.length);
				if (typeof res == 'object' || typeof res == 'array') {
					for (var i = res.length - 1; i >= 0; i--) {
						_collections.push(res[i]);
					}
				}
			};
			var _error = function(res, status, headers, config){
				console.log(res);
				_collections = [];
			}
			
			if (id === undefined) {
				$http.get('api/v1/questions')
				.success(_success)
				.error(_error);
			} else {
				$http.get('api/v1/form/'+id+'/questions')
				.success(_success)
				.error(_error);
			}
		}

		this.constructor = function() {
			_getCollections();
		}
		this.all = function(formID) {
			if (formID !== undefined) {
				_getCollections(formID);
			}
			return _collections;
		}
		this.insert = function(form, question) {
			$http.post('api/v1/question', question)
			.success(function(res, status, headers, config){
				_collections.push(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.update = function(question) {
			$http.put('api/v1/question', question)
			.success(function(res, status, headers, config){
				console.log(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.remove = function(question) {
			$http.delete('api/v1/question/'+question.id)
			.success(function(res, status, headers, config){
				_collections = ArrayHelper.remove(question, _collections);
			})
			.error(function(res, status, headers, config){
				//Code
			});
		}


		this.constructor();
	})

	.service('Groups', function($http, ArrayHelper){
		var _collections = [];
		var _subscribers = [];

		this.constructor = function() {
			$http.get('api/v1/question-groups')
			.success(function(res, status, headers, config){
				if (typeof res == 'object' || typeof res == 'array') {
					for (var i = res.length - 1; i >= 0; i--) {
						_collections.push(res[i]);
					}
				}
			})
			.error(function(res, status, headers, config){
				console.log(res);
				_collections = [];
			});
		}
		this.all = function(group) {
			return _collections;
		}
		this.insert = function(group) {
			$http.post('api/v1/question-group', group)
			.success(function(res, status, headers, config){
				_collections.push(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.update = function(group) {
			$http.put('api/v1/question-group', group)
			.success(function(res, status, headers, config){
				console.log(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.remove = function(payload) {
			$http.delete('api/v1/question-group/'+payload.id)
			.success(function(res, status, headers, config){
				_collections = ArrayHelper.remove(payload, _collections);
			})
			.error(function(res, status, headers, config){
				//Code
			});
		}


		this.constructor();
	})

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

	.directive('formSelect', function($questionaire, $state){
		return {
			restrict: 'E',
			templateUrl: 'template/shared/form-select',
			controllerAs: 'nav',
			controller: function($scope, $element, $attrs){
				var _this = this;

				var _changeState = function() {
					$state.go('question-grouping.show', {
						form:_this.form, 
						formID:_this.form.id
					})
				}

				$questionaire.all(function(forms) {
					_this.forms = forms;
					if (forms.length > 0) {
						_this.select(forms[0]);
					}
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

	.controller('GroupFormController', function($scope, $element, $attrs, Groups){
		$scope.group = null;
		$scope.groups = Groups.all();

		$scope.addGroup = function(group) {
			Groups.insert({
				name: group.name
			});
			$scope.group.name = '';
		}
	})

	.controller('GroupListController', function($scope, $attrs, $state, Groups){
		var _form = $state.params.form || null;
		var _group = $state.params.group || null;
		var _formID = $state.params.formID || null;
		var _groupID = $state.params.groupID || null;
		$scope.currentGroup = null;
		$scope.groups = Groups.all();

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
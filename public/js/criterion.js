(function(){
	
	var module = angular.module('criterion', [])

	.service('Criteria', function($http, ArrayHelper){
		var _collections = [];
		var _getCollections = function(fid, gid) {
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
			
			if (fid || gid) {
				$http.get('api/v1/form/'+fid+'/group/'+gid+'/criteria')
				.success(_success)
				.error(_error);
			} else {
				$http.get('api/v1/criteria')
				.success(_success)
				.error(_error);
			}
		}

		this.constructor = function() {
			_getCollections();
		}
		this.all = function(formID, groupID) {
			if (formID || groupID) {
				_getCollections(formID, groupID);
			}
			return _collections;
		}
		this.insert = function(criterion) {
			$http.post('api/v1/criterion', criterion)
			.success(function(res, status, headers, config){
				_collections.push(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.update = function(criterion) {
			$http.put('api/v1/criterion', criterion)
			.success(function(res, status, headers, config){
				console.log(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.remove = function(criterion) {
			$http.delete('api/v1/criterion/'+criterion.id)
			.success(function(res, status, headers, config){
				_collections = ArrayHelper.remove(criterion, _collections);
			})
			.error(function(res, status, headers, config){
				//Code
			});
		}

		this.constructor();
	})

	.service('$criterion', function(){
		this.newInstance = function() {
			return {
				id: -1,
				label: "ดี, พอใช้, ปรับปรุง",
				from: 0,
				to: 0
			}
		}
	})

	.controller('CriteriaFormController', function($scope, $state, Criteria){
		var _formID = $state.params.formID || null;
		var _groupID = $state.params.groupID || null;

		$scope.criterion = null;
		$scope.addCriterion = function(criterion) {
			Criteria.insert({
				label: criterion.label,
				from: criterion.from,
				to: criterion.to,
				questionaireID: _formID,
				groupID: _groupID
			});
			$scope.criterion.label = '';
			$scope.criterion.from = '';
			$scope.criterion.to = '';
		}
	})

	.controller('CriteriaListController', function($scope, $state, Criteria){
		var _form = $state.params.form || null;
		var _formID = $state.params.formID || null;
		var _group = $state.params.group || null;
		var _groupID = $state.params.groupID || null;

		$scope.criteria = Criteria.all(_formID, _groupID);
		$scope.removeCriterion = function(criterion) {
			Criteria.remove(criterion);
		}
	})
	
	.directive('criteriaForm', function(){
		return {
			scope: true,
			restrict: 'E',
			templateUrl: 'template/criteria/form',
			controllerAs: 'criteriaForm',
			controller: 'CriteriaFormController'
		}
	})

	.directive('criteriaList', function(){
		return {
			scope: true,
			restrict: 'E',
			templateUrl: 'template/criteria/list',
			controllerAs: 'criteriaList',
			controller: 'CriteriaListController'
		}
	})

})();
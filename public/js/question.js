(function(){
	
	var module = angular.module('question', [])

	.service('Questions', function($http, ArrayHelper){
		var _collections = [];
		var _subscribers = [];

		var _getCollections = function(id) {
			var _success = function(res, status, headers, config){
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
		this.insert = function(form, group) {
			$http.post('api/v1/form/'+form.id+'/question', group)
			.success(function(res, status, headers, config){
				_collections.push(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.update = function(form, group) {
			$http.put('api/v1/form/'+form.id+'/question', group)
			.success(function(res, status, headers, config){
				console.log(res);
			})
			.error(function(res, status, headers, config){
				console.log(res);
			});
		}
		this.remove = function(payload) {
			$http.delete('api/v1/question/'+payload.id)
			.success(function(res, status, headers, config){
				_collections = ArrayHelper.remove(payload, _collections);
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

})();
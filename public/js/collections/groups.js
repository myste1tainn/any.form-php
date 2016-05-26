(function(){
	
	var module = angular.module('Groups', [])

	.service('Groups', function($http, ArrayHelper){
		var _collections = [];
		var _subscribers = [];

		var _getCollections = function(id){
			var _success = function(res, status, headers, config){
				_collections.splice(0, _collections.length);
				if (typeof res == 'object' || typeof res == 'array') {
					for (var i = res.length - 1; i >= 0; i--) {
						_collections.push(res[i]);
					}
				}
			}
			var _error = function(res, status, headers, config){
				console.log(res);
				_collections = [];
			}
			
			if (id) {
				$http.get('api/v1/form/'+id+'/question-groups')
				.success(_success)
				.error(_error);
			} else {
				$http.get('api/v1/question-groups')
				.success(_success)
				.error(_error);
			}
		}

		this.constructor = function() {
			// _getCollections();
		}
		this.all = function(formID) {
			_getCollections(formID);
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

})();
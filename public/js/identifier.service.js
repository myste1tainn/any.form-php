(function(){
	
	var module = angular.module('identifier.service', [])

	.service('identifierSerivce', function($http){
		this.new = function() {
			return {
				id: '',
				table: '',
				description: null,
				relatedIDs: ''
			}
		}
		this.load = function(id, callback){
			if (!!callback && typeof id == 'function') {
				callback = id;
				id = null;
			}

			var uri = 'api/v1/identifiers';
			if (id) {
				uri = 'api/v1/identifier'+id;
			}

			$http.get(uri)
			.success(function(res, status, headers, config){
				callback(res.results, res.message);
			})
			.error(function(res, status, headers, config){
				callback(null, res.message)
			});
		}

		this.add = function(identifier, callback) {
			$http.post('api/v1/identifier', identifier)
			.success(function(res, status, headers, config){
				callback(res.results, res.message);
			})
			.error(function(res, status, headers, config){
				callback(null, res.message);
			});
		}

		this.update = function(identifier, callback) {
			$http.put('api/v1/identifier/'+identifier.id, identifier)
			.success(function(res, status, headers, config){
				callback(res.results, res.message);
			})
			.error(function(res, status, headers, config){
				callback(null, res.message);
			});
		}

		this.delete = function(id, callback) {
			$http.delete('api/v1/identifier/'+identifier.id, identifier)
			.success(function(res, status, headers, config){
				callback(res.results, res.message);
			})
			.error(function(res, status, headers, config){
				callback(null, res.message);
			});
		}
	})

})();
(function(){
	
	var module = angular.module('definition.service', [])

	.service('definitionService', function($http, $q){
		this.newObject = function() {
			return {
				id: -1, name: 'New Definition', table: null, column: null, values: null
			};
		}

		var _errorHandler = function(res, status, headers, config){
			console.log(res);
		}
		var _successHandler = function(deferred) {
			return function(res, status, headers, config){
				if (status < 300) {
					deferred.resolve(res);
				} else {
					_errorHandler(res, status, headers, config);
				}
			}
		}

		var _performGETRequest = function(url, deferred) {
			$http.get(url)
			.success(_successHandler(deferred))
			.error(_errorHandler);
		}

		this.load = function(id) {
			var deferred = $q.defer();
			var url = (!!id) ? `api/v1/definition/${id}` : `api/v1/definitions`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}

		this.store = function(definition) {
			var deferred = $q.defer();
			var url, httpPromise;
			if (definition.id > -1) {
				// update
				url = `api/v1/definition/${definition.id}`;
				httpPromise = $http.put(url, definition);
			} else {
				// create
				url = `api/v1/definition`;
				httpPromise = $http.post(url, definition);
			}
			httpPromise
			.success(_successHandler(deferred))
			.error(_errorHandler);
			return deferred.promise;
		}

		this.destroy = function(definition) {
			var deferred = $q.defer();
			var url = `api/v1/definition/${definition.id}`;
			$http.delete(url)
			.success(_successHandler(deferred))
			.error(_errorHandler);
			return deferred.promise;
		}
	})

	.service('schemaTableService', function($http, $q){
		var _errorHandler = function(res, status, headers, config){
			console.log(res);
		}
		var _successHandler = function(deferred) {
			return function(res, status, headers, config){
				if (status == 200) {
					deferred.resolve(res);
				} else {
					_errorHandler(res, status, headers, config);
				}
			}
		}

		var _performGETRequest = function(url, deferred) {
			$http.get(url)
			.success(_successHandler(deferred))
			.error(_errorHandler);
		}

		this.load = function() {
			var deferred = $q.defer();
			var url = `api/v1/definition/tables`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}
		this.loadValues = function(name, attr) {
			var deferred = $q.defer();
			var url = `api/v1/definition/table/${name}/column/${attr}`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}
	})

	.service('schemaColumnService', function($http, $q){
		var _errorHandler = function(res, status, headers, config){
			console.log(res);
		}
		var _successHandler = function(deferred) {
			return function(res, status, headers, config){
				if (status == 200) {
					deferred.resolve(res);
				} else {
					_errorHandler(res, status, headers, config);
				}
			}
		}

		var _performGETRequest = function(url, deferred) {
			$http.get(url)
			.success(_successHandler(deferred))
			.error(_errorHandler);
		}

		this.load = function(name) {
			var deferred = $q.defer();
			var url = `api/v1/definition/table/${name}/columns`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}
	})

	.service('schemaValueService', function($http, $q){
		var _errorHandler = function(res, status, headers, config){
			console.log(res);
		}
		var _successHandler = function(deferred) {
			return function(res, status, headers, config){
				if (status == 200) {
					deferred.resolve(res);
				} else {
					_errorHandler(res, status, headers, config);
				}
			}
		}

		var _performGETRequest = function(url, deferred) {
			$http.get(url)
			.success(_successHandler(deferred))
			.error(_errorHandler);
		}

		this.load = function(name, columnName) {
			var deferred = $q.defer();
			var url = `api/v1/definition/table/${name}/column/${columnName}`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}
	})

})();
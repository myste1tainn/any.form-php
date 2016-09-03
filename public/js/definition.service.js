(function(){
	
	var module = angular.module('definition.service', [])

	.service('definitionService', function($http, $q){
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

		this.load = function(id) {
			var deferred = $q.defer();
			var url = (!!id) ? `api/v1/definition/${id}` : `api/v1/definitions`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}
		this.loadTables = function() {
			var deferred = $q.defer();
			var url = `api/v1/definition/tables`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}
		this.loadColumns = function(name) {
			var deferred = $q.defer();
			var url = `api/v1/definition/table/${name}/columns`;
			_performGETRequest(url, deferred);
			return deferred.promise;
		}
		this.loadValues = function(name, attr) {
			var deferred = $q.defer();
			var url = `api/v1/definition/table/${name}/column/${attr}`;
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
			.success(_successHandler)
			.error(_errorHandler);
			return deferred.promise;
		}
	})

	.service('definitionBuilder', function($q){

		var _deferred = $q.defer();

		this.constructor = function() {
			this.clear();
		}

		// TODO: This should have more granularity
		// The current state listener can't tell which data is changed.
		// Take a look at ColumnListController, it reloads column list every time
		// the data change be it name or other fields
		this.ifChange = function() {
			return _deferred.promise;
		}
		this.notify = function() {
			_deferred.notify(this);
		}

		this.clear = function() {
			this.id = null;
			this.name = null;
			this.attribute = null;
			this.values = null;
		}

		this.newObject = function() {
			return {
				id: -1, name: 'New Definition', attribute: null, values: null
			};
		}

		this.build = function() {
			var _definitionObject = {};
			_definitionObject.id = this.id;
			_definitionObject.name = this.name;
			_definitionObject.attribute = this.attribute;
			_definitionObject.values = this.values;
			this.clear();
			return _definitionObject;
		}

		this.constructor();

	})

})();
(function(){
	
	var module = angular.module('definition', ['definition.service'])

	.controller('DefinitionListController', function($scope, definitionService, definitionBuilder){
		$scope.results = [];

		var _loadData = function() {
			definitionService.load().then(function(res){
				$scope.results = res;
			})
		}
		var _removeItem = function(definition) {
			var i = $scope.results.indexOf(definition);
			if (i > -1) $scope.results.splice(i, 1);
		}

		$scope.constructor = function(){
			_loadData();
		}

		$scope.select = function(definition) {
			definitionBuilder.id = definition.id;
			definitionBuilder.name = definition.name;
			definitionBuilder.attribute = definition.attribute;
			definitionBuilder.values = definition.values;
			definitionBuilder.notify();
		}

		$scope.add = function() {
			$scope.results.push(definitionBuilder.newObject());
		}

		$scope.save = function() {
			definitionService.store(definitionBuilder.build()).then(function(){
				
			})
		}

		$scope.delete = function(definition) {
			if (definition.id > -1) {
				definitionService.destroy(definition).then(function(res){
					_removeItem(definition);	
				});
			} else {
				_removeItem(definition);
			}
		}

		$scope.constructor();
	})

	// TODO: Looks like the code for table list repeat itself so much.
	// Maybe you can create something generalized from it like UITableView in ObjC
	// By allowing attribute setting on element of multiple/single selection mode
	// Logic is switch accordingly.
	// By subclassing this so called UITableView, the subclass should have the freedom
	// to modify certain part of the code and do super.method() for the same functionality
	//
	// Maybe these controller are meant to be UITableViewDelegate, not the UITableView itself
	// The UITableView itself should be some central code that can operate by just switching
	// the service provider (e.g. definitionService) which acts as a data source
	//
	// What to do with the data when it is selected is up to these supposedly-to-be delegates

	// TODO: Test this untested code.
	.controller('TableListController', function($scope, definitionService, definitionBuilder){
		$scope.selectedItem = null;
		$scope.results = [];

		var _loadData = function() {
			definitionService.loadTables().then(function(res) {
				$scope.results = res;
			})
		}

		$scope.constructor = function() {
			_loadData();
		}

		$scope.select = function(item) {
			definitionBuilder.name = item.name;
			definitionBuilder.notify();
		}

		definitionBuilder.ifChange().then(null, null, function(db){
			if (!!definitionBuilder.name) {
				for (var i = $scope.results.length - 1; i >= 0; i--) {
					$scope.results[i].name = definitionBuilder.name;
					$scope.selectedItem = $scope.results[i];
					break;
				}
			}
		})

		$scope.constructor();
	})

	// TODO: Test this untested code.
	.controller('ColumnListController', function($scope, definitionService, definitionBuilder){
		$scope.selectedItem = null;
		$scope.results = [];

		var _loadData = function() {
			if (!!definitionBuilder.name) {
				// Load data only when the table name is known;
				definitionService.loadColumns(definitionBuilder.name).then(function(res) {
					$scope.results = res;
				})
			}
		}

		$scope.constructor = function() {
			_loadData();
		}

		$scope.select = function(item) {
			definitionBuilder.attribute = item.attribute;
		}

		definitionBuilder.ifChange().then(null, null, function(db){
			_loadData();

			if (!!definitionBuilder.attribute) {
				for (var i = $scope.results.length - 1; i >= 0; i--) {
					$scope.results[i].attribute = definitionBuilder.attribute;
					$scope.selectedItem = $scope.results[i];
					break;
				}
			}
		})

		$scope.constructor();
	})

	// TODO: Test this untested code.
	// TODO: This serves as an example code logic for multiple selection enabled table view
	.controller('ValueListController', function($scope, definitionService, definitionBuilder){
		$scope.selectedItems = [];
		$scope.results = [];

		var _loadData = function() {
			if (!!definitionBuilder.name) {
				// Load data only when the table name is known;
				definitionService.loadColumns(definitionBuilder.name).then(function(res) {
					$scope.results = res;
				})
			}
		}

		$scope.constructor = function() {
			_loadData();
		}

		$scope.select = function(item) {
			var i = $scope.selectedItems.indexOf(item);
			if (i > -1) {
				$scope.selectedItems.splice(i, 1);
			} else {
				$scope.selectedItems.push(item);
			}
			definitionBuilder.value = $scope.selectedItems;
		}

		definitionBuilder.ifChange().then(null, null, function(db){
			if (!!definitionBuilder.attribute) {
				for (var i = $scope.results.length - 1; i >= 0; i--) {
					for (var j = definitionBuilder.values.length - 1; j >= 0; j--) {
						$scope.results[i] = definitionBuilder.values[j];

						// The item is already exists, break;
						var foundItem = $scope.results[i];
						var i = $scope.selectedItems.indexOf(foundItem);
						if (i > -1) break;

						// Add to selected collection
						$scope.selectedItems.push($scope.results[i]);

						// One item in values can only be found once in results, 
						// so break it and go for next round.
						break;
					}
				}
			}
		})

		$scope.constructor();
	})

})();
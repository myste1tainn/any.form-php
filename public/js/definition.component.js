(function(){
	
	var module = angular.module('definition', ['definition.service'])

	.directive('tableNameCell', function($http){
		return {
			restrict: 'E',
			templateUrl: 'template/common/table-name-cell'
		}
	})
	.directive('columnNameCell', function($http){
		return {
			restrict: 'E',
			templateUrl: 'template/common/column-name-cell'
		}
	})
	.directive('valueCell', function($http){
		return {
			restrict: 'E',
			templateUrl: 'template/common/column-name-cell',
			controller: function($scope){}
		}
	})
	.directive('definitionCell', function($http){
		return {
			restrict: 'E',
			require: '^definitionForm',
			link: function($scope, $element, $attrs, $controller){
				this.definitionForm = $controller;
			},
			templateUrl: 'template/common/definition-cell',
			controller: function($scope){
				// Link to defintionForm.save()
				this.save = function(item) {
					this.definitionForm.save(item);
				}
			}
		}
	})

	.directive('definitionForm', function($http){
		return {
			restrict: 'E',
			controllerAs: 'definitionForm',
			controller: 'DefinitionFormController'
		}
	})

	.controller('DefinitionFormController', function(
		$scope, definitionService, schemaTableService, schemaColumnService, schemaValueService
	) {
		TableViewDelegate.call(this);
		TableViewDataSource.call(this);

		var _this			= this;
		var _definitions 	= [];
		var _tableNames 	= [];
		var _columnNames 	= [];
		var _values 		= [];

		var _loadDefinitions = function() {
			definitionService.load().then(function(res){ 
				_definitions = res;
				_this.definitionList.reloadData();
				_this.definitionList.selectAtIndex(0);
			});
		}
		var _loadTables = function() {
			schemaTableService.load().then(function(res){ 
				_tableNames = res;
				_this.tableNameList.reloadData();
			});
		}
		var _loadColumns = function(tableName) {
			schemaColumnService.load(tableName).then(function(res){ 
				_columnNames = res;
				_this.columnNameList.reloadData();
			});
		}
		var _loadValues = function(tableName, columnName) {
			schemaValueService.load(tableName, columnName).then(function(res){ 
				_values = res;
				_this.valueList.reloadData();
			});
		}

		this.constructor = function() {
			_loadDefinitions();
		}

		this.add = function() {
			var item = definitionService.newObject();
			_definitions.unshift(item);
			this.definitionList.reloadData();
			this.definitionList.select(item);
		}

		this.viewDidLoad = function(view) {
			if (view == this.tableNameList) {
				_loadTables();
			}
		}
		this.tableViewCommitEditingForItem = function(tableView, type, item) {
			// We knows that this is always a definitionList, thus item is always a definition object
			if (type == 'delete') {
				var last = tableView.results.length - 2;
				if (item.id > -1) {
					definitionService.destroy(item).then(function(res){
						tableView.commitDelete(item);
						tableView.select(tableView.results[last]);
					})
				} else {
					tableView.commitDelete(item);
					tableView.select(tableView.results[last]);
				}
			} else if (type == 'edit') {
				for (var i = item.values.length - 1; i >= 0; i--) {
					item.values[i] = item.values[i].name;
				}
				
				definitionService.store(item).then(function(res){
					item.id = res.id;
				})
			}
		}
		this.tableViewDidSelectItem = function(tableView, item) {
			if (tableView == this.tableNameList) {
				var table = this.tableNameList.selectedItem.name;
				_loadColumns(table);

				this.definitionList.selectedItem.table = tableView.selectedItem.name;
			} else if (tableView == this.columnNameList) {
				var table = this.tableNameList.selectedItem.name;
				var column = this.columnNameList.selectedItem;
				_loadValues(table, column);

				this.definitionList.selectedItem.column = tableView.selectedItem;
			} else if (tableView == this.valueList) {
				this.definitionList.selectedItem.values = tableView.selectedItems;
			}
		}
		this.tableViewDidDeselectItem = function(tableView, item) {
			// Only value list table has multi selection enabled
			if (tableView == this.valueList) {
				this.definitionList.selectedItem.values = tableView.selectedItems;
			}
		}
		this.itemsForTableView = function(tableView) {
			if (tableView == this.definitionList) {
				return _definitions;
			} else if (tableView == this.tableNameList) {
				return _tableNames;
			} else if (tableView == this.columnNameList) {
				return _columnNames;
			} else if (tableView == this.valueList) {
				return _values;
			}
		}

		this.constructor();
	})

	

})();
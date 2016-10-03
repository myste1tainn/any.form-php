(function(){
	
	var module = angular.module('tableView', [])

	.directive('tableView', function(){
		return {
			scope: true,
			restrict: 'E',
			templateUrl: 'template/common/table-list',
			controllerAs: 'tableView',
			controller: 'TableViewController'
		}
	})

	.directive('tableViewCell', function($compile){
		return {
			restrict: 'E',
			replace: true,
			require: '^tableView',
			link: function($scope, $element, $attrs, $controller){},
			controllerAs: 'DefinitionCell',
			controller: function($scope, $element, $attrs){
				$scope.item = $scope.$eval($attrs.item);
				var name = $scope.$eval($attrs.name);
				html = `<${name}></${name}>`;
				$element.html(html);
				$compile($element.contents())($scope);
			}
		}
	})

	.controller('TableViewController', function($scope, $element, $attrs){
		var _this = this;
		this.selectedItem = null;
		this.selectedItems = [];
		this.results = [];

		this.constructor = function() {
			this.identifier = $attrs.tableViewId;
			this.delegate = $scope.$eval($attrs.tableViewDelegate);
			this.dataSource = $scope.$eval($attrs.tableViewDataSource);
			this.multipleSelectionMode = $attrs.tableViewMultiselection;
			this.cellDirective = $attrs.tableViewCellDirective;

			this.delegate[this.identifier] = this;
			this.delegate.viewDidLoad(this);
		}

		this.isSelected = function(item) {
			if (this.multipleSelectionMode) {
				return this.selectedItems.indexOf(item) > -1;
			} else {
				return item == this.selectedItem;
			}
		}

		this.select = function(item) {
			if (this.multipleSelectionMode) {
				var i = this.selectedItems.indexOf(item);
				if (i > -1) {
					this.selectedItems.splice(i, 1);
					if (this.delegate) {
						this.delegate.tableViewDidDeselectItem(this, item);
					}
				} else {
					this.selectedItems.push(item);
					if (this.delegate) {
						this.delegate.tableViewDidSelectItem(this, item);
					}
				}
			} else {
				this.selectedItem = item;
				if (this.delegate) {
					this.delegate.tableViewDidSelectItem(this, item);
				}
			}
		}
		this.selectAtIndex = function(index) {
			if (index < this.results.length) {
				this.select(this.results[index]);
			}
		}

		var _removeItem = function(item){
			var i = _this.results.indexOf(item);
			if (i > -1) {
				_this.results.splice(i, 1);
			}
		}

		this.save = function(item) {
			if (this.delegate) {
				this.delegate.tableViewCommitEditingForItem(this, 'edit', item);
			}
		}
		this.delete = function(item) {
			if (this.delegate) {
				this.delegate.tableViewCommitEditingForItem(this, 'delete', item);
			}
		}
		this.commitDelete = function(item) {
			_removeItem(item);
		}

		this.reloadData = function() {
			// TODO: [LATER] should the selection be reload everytimes data is reloaded like this?
			if (this.dataSource) {
				this.results = this.dataSource.itemsForTableView(this);
				this.selectedItem = null;
				this.selectedItems = [];
			}
		}

		this.constructor();
	})

})();
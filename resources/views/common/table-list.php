<div class="col-xs-12 no-pad">
	<input class="col-xs-12" ng-model="filterText" />
	<div class="col-xs-12" 
		 ng-repeat="item in tableView.results | filter:filterText" 
		 ng-click="tableView.select(item)"
		 ng-class="{'selected': tableView.isSelected(item)}">
		<table-view-cell name="tableView.cellDirective" item="item"></table-view-cell>
	</div>
</div>
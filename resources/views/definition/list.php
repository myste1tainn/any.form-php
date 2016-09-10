<div class="col-xs-12 no-pad">
	<div class="col-xs-12 border-bottom border-color-tertiary-tinted">
		<p class="pull-left std-pad-tb no-margin">Definitions</p>
		<button class="pull-right std-pad-tb no-margin" ng-click="add()">Add</button>
	</div>
	<div class="col-xs-12 no-pad">
		<div class="col-xs-12" 
			 ng-repeat="item in results" 
			 ng-click="select(item)"
			 ng-class="{'selected': isSelected(item)}">
			<div ng-if="item.isSaving" class="match-parent" style="position: absolute; background: black; z-index: 9999; left: 0;"></div>
			<div class="col-xs-8 std-pad-tb no-pad-left no-pad-right">
				<input ng-model="item.name" name="name" />
			</div>
			<button class="pull-right std-pad-tb no-margin" ng-click="delete(item)">Del</button>
			<button class="pull-right std-pad-tb no-margin" ng-click="save(item)">Sav</button>
		</div>
	</div>
</div>
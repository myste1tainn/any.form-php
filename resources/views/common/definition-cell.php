<div ng-if="item.isSaving" class="match-parent" style="position: absolute; background: black; z-index: 9999; left: 0;"></div>
<div class="col-xs-8 std-pad-tb no-pad-left no-pad-right">
	<input ng-model="item.name" name="name" />
</div>
<button class="pull-right std-pad-tb no-margin" ng-click="tableView.delete(item)">Del</button>
<button class="pull-right std-pad-tb no-margin" ng-click="tableView.save(item)">Sav</button>
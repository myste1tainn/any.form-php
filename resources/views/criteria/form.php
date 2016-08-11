<form ng-submit="addCriterion(criterion)" class="no-pad space-top">
	<input  class="col-xs-12" type="text" ng-model="criterion.label" placeholder="label">
	<input  class="col-xs-4" type="text" ng-model="criterion.from" placeholder="from">
	<input  class="col-xs-4" type="text" ng-model="criterion.to" placeholder="to">
	<button class="col-xs-4" >Add</button>
</form>
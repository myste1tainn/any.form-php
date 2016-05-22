<div class="col-xs-12 no-pad">
	<div class="col-xs-12 border-b std-pad" 
		 ng-repeat="criterion in criteria">
		<div class="col-xs-10">
			{{ criterion.label }} ({{criterion.from}} - {{criterion.to}})
		</div>
		<button class="col-xs-2" ng-click="removeCriterion(criterion)">
			Del
		</button>
	</div>
</div>
<div class="col-xs-12 no-pad">
	<div class="col-xs-12 border-b std-pad" ng-repeat="group in groups">
		<div class="col-xs-10">
			{{ group.name }}
		</div>
		<button class="col-xs-2" ng-click="removeGroup(group)">
			Del
		</button>
	</div>
</div>
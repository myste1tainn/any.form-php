<div class="col-xs-12 no-pad">
	<div class="col-xs-12 border-b std-pad" 
		 ng-repeat="group in groups">
		<div class="col-xs-10">
			<span class="col-xs-12" 
				  ng-click="selectGroup(group)">
				  {{ group.name }}
			</span>
			<span class="col-xs-12" 
				  ng-if="!group.editLabel"
				  ng-click="beginEditGroup(group)">
				  <small>{{ group.label || '>> no label <<' }}</small>
			</span>
			<form class="col-xs-12"
				  ng-if="group.editLabel"
				  ng-submit="updateGroup(group)">
				<small><input type="text" ng-model="group.label"></small>
			</form>
		</div>
		<button class="col-xs-2" ng-click="removeGroup(group)">
			Del
		</button>
	</div>
</div>
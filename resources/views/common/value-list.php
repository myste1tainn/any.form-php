<div class="col-xs-12 no-pad">
	<div class="col-xs-12 border-bottom border-color-tertiary-tinted">
		<p class="pull-left std-pad-tb no-margin">Values</p>
	</div>
	<div class="col-xs-12 no-pad">
		<div class="col-xs-12" 
			 ng-repeat="item in results" 
			 ng-click="select(item)"
			 ng-class="{'selected': isSelected(item)}">
			<div class="col-xs-10 std-pad-tb no-pad-left no-pad-right">
				{{ item }}
			</div>
		</div>
	</div>
</div>
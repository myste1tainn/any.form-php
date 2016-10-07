<div class="point" 
	 ng-repeat="d in graph.data"
	 ng-class="{'bg-alarming-light': graph.isInRange($index) }">
	<div ng-if="!graph.isValue($index)">
		&nbsp;
	</div>
	<div ng-if="graph.isValue($index)">
		&nbsp;
		<div class="circle" style="height: 14px; width: 14px; margin-top: -24px; position: absolute;"
			 ng-class="{'bg-destructive' : level == 0, 'bg-alarming' : level == 1, 'bg-friendly' : level == 2}">
			&nbsp;
		</div>
	</div>
</div>
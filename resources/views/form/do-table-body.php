<tr ng-repeat="r in q.meta.header.rows">
	<th ng-repeat="c in r.cols"
		rowspan="{{ c.rowspan }}" 
		colspan="{{ c.colspan }}"
		class="bgcolor-secondary theme-border">
		{{ c.label }}
	</th>
</tr>
<tr ng-if="q.type == 0">
	<td class="border text-right">{{ q.label }}</td>
	<td class="border text-left">{{ q.name }}</td>
	<td ng-repeat="c in q.choices" 
		ng-class="{'selected' : isChoosen(q, c)`"
		ng-click="toggleChoose(q, c)"
		class="bgcolor-secondary theme-border choice">
	</td>
</tr>
<tr ng-if="q.type == 1" class="no-border std-pad">
	<td colspan="{{questionaire.header.rows[0].cols.length || 5}}" 
		class="std-pad"
		ng-repeat="c in q.choices">
		
		<div>
			<span class="col-xs-12">{{ q.name }}</span>
			<textarea placeholder="{{c.inputs[0].placeholder}}"
					  ng-model="c.inputs[0].value"
					  class="col-xs-12 border"></textarea>
		</div>

	</td>
</tr>
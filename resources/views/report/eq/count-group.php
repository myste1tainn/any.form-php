<table class="col-xs-12 no-pad">
	<tr class="no-border">
		<!-- TODO: The width style is quick patch, should figure on proper width from number of criteria -->
		<td class="text-center" ng-repeat="item in items" style="width: 33.33333%">
			{{ item.count || 0 }}
		</td>
	</tr>
</table>
<table>
	<tr>
		<td colspan="1" style="width:10%">
			<button ng-click="addAdditionalInputs(choice)">+</button>
			<button ng-click="toggleFold(choice)">==</button>
		</td>
		<td colspan="6" style="width:90%">
			<b>Addtional Inputs</b>
		</td>
	</tr>
	<tr ng-repeat="input in choice.inputs" 
		class="classified cho" 
		ng-if="!choice.folded">

		<td colspan="1" class="choice">
		</td>

		<td colspan="6">
			<table>
				<tr>
					<td colspan="1">Name</td>
					<td colspan="1">
						<input name="input-name" ng-model="input.name" type="text" />
					</td>
					<td colspan="1">Placeholder</td>
					<td colspan="1">
						<input name="input-placeholder" ng-model="input.placeholder" type="text" />
					</td>
					<td colspan="1">Type</td>
					<td colspan="1">
						<input name="input-type" ng-model="input.type" type="text" />
					</td>
				</tr>
			</table>

		</td>

	</tr>
</table>
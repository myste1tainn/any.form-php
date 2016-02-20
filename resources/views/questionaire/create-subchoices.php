<table>
	<tr>
		<td colspan="1" style="width:10%">
			<button ng-click="addSubchoice(choice)">+</button>
			<button ng-click="toggleFold(choice)">==</button>
		</td>
		<td colspan="6" style="width:90%">
			<b>Subchoice</b>
		</td>
	</tr>
	<tr ng-repeat="subchoice in choice.subchoices" 
		class="classified cho" 
		ng-if="!choice.folded">

		<td colspan="1" class="choice">
			<input subchoice-enabled-toggler
				   ng-model="subchoice.enabled"
				   ng-change="toggleEnabled(subchoice)"
				   ng-checked="subchoice.enabled == 1"
				   type="checkbox" /> enabled
		</td>

		<td colspan="6">
			<table>
				<tr>
					<td>ฉลาก</td>
					<td>
						<input name="subchoice-label" ng-model="subchoice.label" type="text" />
					</td>
					<td>คะแนน</td>
					<td>
						<input name="subchoice-value" ng-model="subchoice.value" type="text" />
					</td>
					<td>หมายเหตุ</td>
					<td>
						<input name="subchoice-note" ng-model="subchoice.note" type="text" />
					</td>
				</tr>
				<tr>
					<td colspan="1">ชื่อ</td>
					<td colspan="1">
						<input name="subchoice-name" ng-model="subchoice.name" type="text" />
					</td>
					<td colspan="1">คำบรรยาย</td>
					<td colspan="3">
						<input name="subchoice-description" ng-model="subchoice.description" type="text" />
					</td>
				</tr>
			</table>

		</td>

	</tr>
</table>
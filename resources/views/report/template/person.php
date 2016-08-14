<div class="col-xs-12 std-pad">

	<table class="form questions" 
		   st-table="displayedResults" 
		   st-safe-src="results">
		<thead>
			<tr>
				<td colspan="5">
					<input st-search="" 
						   class="form-control" 
						   placeholder="ค้นหา" 
						   type="text"/>
				</td>
			</tr>
			<tr>
				<th st-sort="participant.firstname">ชื่อ</th>
				<th st-sort="participant.class">ชั้น</th>
				<th st-sort="participant.room">ห้อง</th>
				<th st-sort="value">ระดับความเสี่ยง</th>
			</tr>
		</thead>
		<tr ng-repeat="r in displayedResults">
			<td class="text-left">
				{{ r.firstname }} {{ r.lastname }}
			</td>
			<td class="text-center">{{ r.class }}</td>
			<td class="text-center">{{ r.room }}</td>
			<td>{{ r.risk }} ({{ r.value }})</td>
		</tr>
	</table>
</div>
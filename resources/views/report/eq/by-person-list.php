<div class="col-xs-12 no-pad border-t">

	<table class="risk-body">
		<tr>
			<th rowspan="2" style="width: 12%">รหัสประจำตัว</th>
			<th rowspan="2" style="width: 27%">ชื่อ</th>
			<th rowspan="2" style="width: 27%">ห้อง</th>
			<th rowspan="2" style="width: 12%">เลขที่</th>
			<th colspan="3">ระดับความเสี่ยง</th>
		</tr>
		<tr>
			<th>ดี</th>
			<th>เก่ง</th>
			<th>สุข</th>
		</tr>
		<tr ng-repeat="p in results"
			ng-click="showDetail(p)"
			ng-class="{'odd': ($index % 2 == 1)}">
			<td class="text-center">{{ p.identifier }}</td>
			<td class="text-left">{{ p.firstname }} {{ p.lastname }}</td>
			<td class="text-center">{{ p.class }}/{{ p.room }}</td>
			<td class="text-center">{{ p.number }}</td>
			<td class="text-center">{{ p.goodside }}</td>
			<td class="text-center">{{ p.skilled }}</td>
			<td class="text-center">{{ p.happiness }}</td>
		</tr>
	</table>

</div>

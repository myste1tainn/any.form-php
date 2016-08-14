<table class="risk-body">
	<tr>
		<th style="width: 12%">รหัสประจำตัว</th>
		<th style="width: 20%">ชื่อ</th>
		<th style="width: 10%">ห้อง</th>
		<th style="width: 10%">เลขที่</th>
		<th style="width: 12%">ระดับความเสี่ยง</th>
	</tr>
	<tr ng-repeat="p in list.displays"
		ng-click="list.select(p)"
		ng-class="{'odd': ($index % 2 == 1)}">
		<td class="text-center">{{ p.identifier }}</td>
		<td class="text-left">{{ p.firstname }} {{ p.lastname }}</td>
		<td class="text-center">{{ p.class }}/{{ p.room }}</td>
		<td class="text-center">{{ p.number }}</td>
		<td class="text-center">{{ p.risk }}</td>		
	</tr>
</table>
<div class="col-xs-12 no-pad border-t">

	<table class="risk-body col-xs-12">
		<tr>
			<th rowspan="2">รหัสประจำตัว</th>
			<th rowspan="2">ชื่อ</th>
			<th rowspan="2">ห้อง</th>
			<th rowspan="2">เลขที่</th>
			<th colspan="3">ด้าน</th>
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
			<td class="text-center">
				<div class="circle" style="width: 16px; height: 16px; margin: auto;"
					 ng-class="{'bg-destructive' : p.levelOf('good') == 0, 'bg-alarming' : p.levelOf('good') == 1, 'bg-friendly' : p.levelOf('good') == 2}">
				</div>
			</td>
			<td class="text-center">
				<div class="circle" style="width: 16px; height: 16px; margin: auto;"
					 ng-class="{'bg-destructive' : p.levelOf('skilled') == 0, 'bg-alarming' : p.levelOf('skilled') == 1, 'bg-friendly' : p.levelOf('skilled') == 2}">
				</div>
			</td>
			<td class="text-center">
				<div class="circle" style="width: 16px; height: 16px; margin: auto;"
					 ng-class="{'bg-destructive' : p.levelOf('happy') == 0, 'bg-alarming' : p.levelOf('happy') == 1, 'bg-friendly' : p.levelOf('happy') == 2}">
				</div>
			</td>
		</tr>
	</table>

</div>

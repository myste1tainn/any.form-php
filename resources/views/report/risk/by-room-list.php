<room class="col-xs-12 std-pad">

	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control" 
				ng-model="nav.year"
				ng-change="nav.yearChange()"
				ng-options="y as y.value for y in nav.years">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ปีการศึกษา</div>


	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="nav.room"
				ng-change="nav.roomChange()"
				ng-options="c as c.value for c in nav.rooms">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ห้อง</div>


	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="nav.class"
				ng-change="nav.classChange()"
				ng-options="c as c.value for c in nav.classes">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ชั้น</div>



	<div ui-view="report.risk.overview">
		
	</div>
	
</room>
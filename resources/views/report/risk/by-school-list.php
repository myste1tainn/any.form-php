<school class="col-xs-12 std-pad">

	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control" 
				ng-model="toolbar.year"
				ng-change="toolbar.yearChange()"
				ng-options="y as y.value for y in toolbar.years">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ปีการศึกษา</div>

	<div ui-view="report.risk.overview">
		
	</div>
	
</school>
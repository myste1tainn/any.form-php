<div class="col-xs-12 no-pad border-t">

	<div class="row std-pad-lr std-pad-bottom border-b border-lightgray" ui-view="report.risk">
		<div class="l-pad-top std-pad-bottom std-pad-lr">
			<div class="col-xs-6">
				<div class="pull-left">
					ปีการศึกษา
				</div>
				<div class="col-xs-4">
					<select class="form-control" 
							ng-model="toolbar.year"
							ng-change="toolbar.yearChange()"
							ng-options="y as y.value for y in toolbar.years">
					</select>
				</div>
				<button ui-sref="report.risk.list({year:toolbar.year.value})">
					ดูรายงาน
				</button>
			</div>

			<div class="col-xs-6">
				<form>
					<button class="pull-right"
							ui-sref="report.risk.detail({participantID: toolbar.searchID, year:toolbar.year.value})">
						ค้นหา
					</button>
					<input class="col-xs-4 pull-right text-center" type="text" 
						   placeholder="เลขประจำตัวนักเรียน" 
						   ng-model="toolbar.searchID">
				</form>
			</div>
		</div>
	</div>

	<div class="col-xs-12 no-pad" ui-view="report.risk.body">
		
	</div>

	<div class="anim-slide-in-bottom modal-over-current-context" 
		 ui-view="report.risk.aspect-detail">

	</div>

</div>
<div class="col-xs-12 no-pad border-t">

	<div class="row std-pad-lr std-pad-bottom border-b border-lightgray" ui-view="report.risk">
		<div class="l-pad-top std-pad-bottom std-pad-lr">
			<div class="col-xs-6">
				ปีการศึกษา
				<select ng-model="toolbar.year">
					<option value="2550">2550</option>
					<option value="2551">2551</option>
					<option value="2552">2552</option>
					<option value="2553">2553</option>
					<option value="2554">2554</option>
					<option value="2555">2555</option>
					<option value="2556">2556</option>
					<option value="2557">2557</option>
					<option value="2558">2558</option>
					<option value="2559">2559</option>
				</select>
				<button ui-sref="report.risk.list({year:toolbar.year})">
					ดูรายงาน
				</button>
			</div>

			<div class="col-xs-6">
				<button class="pull-right"
						ui-sref="report.risk.detail({participantID: toolbar.searchID, year:toolbar.year})">
					ค้นหา
				</button>
				<input class="col-xs-4 pull-right text-center" type="text" 
					   placeholder="เลขประจำตัวนักเรียน" 
					   ng-model="toolbar.searchID">
			</div>
		</div>
	</div>

	<div class="col-xs-12 no-pad" ui-view="report.risk.body">
		
	</div>

	<div class="anim-slide-in-bottom modal-over-current-context" 
		 ui-view="report.risk.aspect-detail">

	</div>

</div>
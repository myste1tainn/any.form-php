<div class="col-xs-12" ui-view="report.type.form">

	<div class="row border-top-bottom border-lightgray">
		<div class="std-pad">
			ปีการศึกษา
			<select ng-model="report.year">
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
			<button ui-sref="report.type.risk.show({year:report.year})">
				ดูรายงาน
			</button>
		</div>
	</div>

	<!-- Report body -->
	<div class="row" ui-view="report.type.risk.show">
		
	</div>

	<div class="anim-slide-in-bottom modal-over-current-context" 
		 ui-view="report.type.risk.detail">

	</div>

</div>
<div class="row std-pad-lr std-pad-bottom border-b border-lightgray" ui-view="report.sdq">
	<div class="std-pad-top">
		<div class="col-xs-4">
			<div class="pull-left">
				ปีการศึกษา
			</div>
			<div class="col-xs-4">
				<select class="form-control" 
						ng-model="year"
						ng-change="yearChange()"
						ng-options="y as y.value for y in years">
				</select>
			</div>
			<button ui-sref="report.sdq.list({year:year.value})">
				ดูรายงาน
			</button>
		</div>

		<div class="col-xs-4">
			<button ng-repeat="page in pages track by $index"
					ng-click="changePage(page)"
					class="clickable"
					style="width: 40px">
				{{page+1}}
			</button>
		</div>

		<div class="col-xs-4">
			<form>
				<button class="pull-right"
						ui-sref="report.sdq.detail({participantID: searchID, year:year.value})">
					ค้นหา
				</button>
				<input class="col-xs-6 pull-right text-center" type="text" 
					   placeholder="เลขประจำตัวนักเรียน" 
					   ng-model="searchID">
			</form>
		</div>
	</div>
</div>
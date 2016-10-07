<style>
	.current-page {
		color: black;
		text-decoration: none;
	}
	.current-page:hover {
		color: black !important;
		text-decoration: none !important;
	}
	button.circled {
		font-size: 16px;
		padding: 0px;
		width: 30px;
		height: 30px;
		border-radius: 50%;
		background: #29d;
		color: white;
	}
	button.circled:hover {
		border-radius: 50%;
		background: #3ae;
		color: white;
	}
</style>
<div class="row std-pad-lr std-pad-bottom border-b border-lightgray">
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
			<button ng-click="getData()">
				ดูรายงาน
			</button>
		</div>

		<div class="col-xs-4">
			<button ng-click="gotoFirstPage()"
					class="clickable circled">
					<<
			</button>
			<button ng-click="goBackwardOneSet()"
					class="clickable circled">
					<
			</button>
			<button ng-repeat="page in pages track by $index"
					ng-click="changePage(page)"
					ng-class="{'current-page': (page == currentPage)}"
					ng-disabled="(page == currentPage)"
					class="clickable"
					style="width: 40px">
				{{page+1}}
			</button>
			<button ng-click="goForwardOneSet()"
					class="clickable circled">
					>
			</button>
			<button ng-click="gotoLastPage()"
					class="clickable circled">
					>>
			</button>
		</div>

		<div class="col-xs-4">
			<form>
				<button class="pull-right"
						ui-sref="ReportDisplay.Detail({participantID: searchID, year:year.value, formID:selectedForm.id})">
					ค้นหา
				</button>
				<input class="col-xs-6 pull-right text-center" type="text" 
					   placeholder="เลขประจำตัวนักเรียน" 
					   ng-model="searchID">
			</form>
		</div>
	</div>
</div>
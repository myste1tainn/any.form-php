@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container form-list">
	<h3>แบบคัดกรองนักเรียนรายบุคคล</h3>
	<hr />
	<div class="col-xs-12" style="padding: 0">

		<!-- <table class="name col-xs-4 pull-right"> -->
		<table class="name col-xs-12">
			<tr>
				<td class="" style="width: 10em">
					<input 	class="text-center" 
							type="number" 
							placeholder="หมายเลขประจำตัว"
							ng-model="participant.identifier" />
				</td>
				<td class="">
					<input ng-model="participant.firstname"
						   placeholder="ชื่อ" />
				</td>
				<td class="">
					<input ng-model="participant.lastname"
						   placeholder="สกุล" />
				</td>
				<td class="" style="width:7%">
					<input class="text-center" 
						   ng-model="participant.class"
						   placeholder="ชั้นปี" />
				</td>
				<td class="" style="width:7%">
					<input class="text-center" 
						   ng-model="participant.room"
						   placeholder="ห้อง" />
				</td>
				<td class="" style="width:7%">
					<input class="text-center" 
						   ng-model="participant.room"
						   placeholder="เลขที่" />
				</td>
			</tr>
		</table>

	</div>

	<br/><br/><br/>

	<div class="col-xs-12" style="padding: 0" ng-repeat="q in screening.questions">

		<div class="col-xs-12 font-weight-bold">
			[[ q.label+'. '+q.name ]]
		</div>

		<div class="std-pad"> </div>

		<div ng-switch="q.type">
			<div ng-switch-when="q.singleSelectionType" class="col-xs-12 std-pad">
				<table>
					<tr ng-repeat="c in q.choices">
						<td style="width:42px;">
							<input type="radio" ng-model="hasTalent" value="1" /> 	
						</td>		
						<td style="width:7%">
							[[ c.name ]]
						</td>
						<td ng-if="c.additionalInputs.length > 0">
							<div ng-repeat="i in c.additionalInputs">
								<input class="col-xs-5 space-left" 
									   ng-model="i.value" 
									   placeholder="i.name" />
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div ng-switch-when="q.multipleSelectionWithSubChoicesType" class="col-xs-12 std-pad">
				<div ng-repeat="c in q.choices" class="col-xs-12">
					<div class="col-xs-6">
						<input type="checkbox" ng-model="c.selected" /> c.name
					</div>
				</div>
			</div>
			<div ng-switch-when="q.multipleSelectionWithSubchoicesType" class="col-xs-12 std-pad">
				<table class="subject">
					<tr>
						<th class="col-xs-4" ng-repeat="c in q.choices">
							<input type="checkbox" ng-model="c.selected"> c.name
						</th>
					</tr>
					<tr>
						<td ng-repeat="c in q.choices">
							<table class="item" ng-repeat="sc in c.subchoices">
								<tr>
									<td><input type="checkbox" ng-model="sc.checked"></td>
									<td>[[ sc.name ]]</td>
									<td ng-if="sc.additionalInputs.length > 0">
										<div ng-repeat="i in sc.additionalInputs">
											<input class="col-xs-5 space-left" 
												   ng-model="i.value" 
												   placeholder="i.name" />
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<div ng-switch-default>
				Unknown Question Type
			</div>
		</div>

	</div>

</div>
@endsection
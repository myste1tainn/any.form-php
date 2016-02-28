@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container form-list" risk-screening>
	<h3>แบบคัดกรองนักเรียนรายบุคคล</h3>
	<hr />
	<form>
		<div class="col-xs-12" style="padding: 0">

			<!-- <table class="name col-xs-4 pull-right"> -->
			<table class="name col-xs-12" participant-info>
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
							   ng-model="participant.number"
							   placeholder="เลขที่" />
					</td>
				</tr>
			</table>

		</div>

		<br/><br/><br/>

		<div class="col-xs-12" style="padding: 0" ng-repeat="q in screening.questions">

			<div class="col-xs-12 font-weight-bold std-pad indent-1" style="background: #eee">
				[[ q.label+' '+q.name ]]
			</div>

			<div ng-switch="q.type">
				<div ng-switch-when="0" class="col-xs-12 std-pad">
					<table>
						<tr ng-repeat="c in q.choices">
							<td style="width:42px;">
								<input type="radio" 
									   name="[[ q.name ]]" 
									   ng-model="q.selected" 
									   ng-value="c" />
							</td>		
							<td>
								[[ c.name ]]
							</td>
							<td ng-if="c.inputs.length > 0">
								<div ng-repeat="i in c.inputs">
									<input class="col-xs-5 space-left" 
										   ng-model="i.value" 
										   placeholder="[[ i.placeholder ]]" />
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div ng-switch-when="1" class="col-xs-11 col-xs-offset-1 std-pad">
					<div class="col-xs-6 indent-2 std-pad" ng-repeat="c in q.choices">
						<input type="checkbox" ng-model="c.checked" class="col-xs-1">
						<div class="col-xs-11">
							<div ng-class="{'col-xs-4' : (c.inputs.length > 0)}">[[ c.name ]]</div>
							<div ng-repeat="i in c.inputs" class="col-xs-8">
								<input ng-model="i.value" 
									   placeholder="[[ i.placeholder ]]" />
							</div>
						</div>
					</div>
				</div>
				<div ng-switch-when="2" class="col-xs-12 std-pad">
					<table class="subject">
						<tr>
							<th class="col-xs-4" ng-repeat="c in q.choices">
								<input type="checkbox" 
									   ng-disabled="!c.checked && c.subchoices.length > 0"
									   ng-model="c.checked"
									   ng-change="checkChoice(c)"> [[ c.name ]]
							</th>
						</tr>
						<tr>
							<td ng-repeat="c in q.choices">
								<table class="item" ng-repeat="sc in c.subchoices">
									<tr>
										<td>
											<input type="checkbox" 
												   ng-model="sc.checked"
												   ng-change="checkSubchoice(sc, c)">
										</td>
										<td ng-click="toggleCheck(sc, c)" style="cursor: pointer">
											[[ sc.name ]]
										</td>
										<td ng-if="sc.inputs.length > 0">
											<div ng-repeat="i in sc.inputs">
												<input class="col-xs-5 space-left" 
													   ng-model="i.value" 
													   placeholder="[[ i.placeholder ]]" />
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

		<button type="submit" 
				ng-click="submit()"
				class="pull-right std-pad std-margin min-w-100 submit" 
				style="margin-bottom:100px">
			บันทึกข้อมูล
		</button>
	</form>

</div>
@endsection
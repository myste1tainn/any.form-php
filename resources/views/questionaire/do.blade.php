@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container do">

	<h3>[[ questionaire.name ]]</h3>
	<hr />

	<div class="col-xs-12" style="padding: 0" participant-info>
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
			</tr>
		</table>
	</div>

	<table class="form questions">
		<tr ng-repeat="r in questionaire.header.rows">
			<th ng-repeat="c in r.cols"
				rowspan="[[ c.rowspan ]]" 
				colspan="[[ c.colspan ]]">
				[[ c.label ]]
			</th>
		</tr>
		<tbody ng-repeat="q in questionaire.questions">
			<tr ng-repeat="r in q.meta.header.rows">
				<th ng-repeat="c in r.cols"
					rowspan="[[ c.rowspan ]]" 
					colspan="[[ c.colspan ]]">
					[[ c.label ]]
				</th>
			</tr>
			<tr ng-if="q.type == 0">
				<td class="text-right">[[ q.label ]]</td>
				<td class="text-left">[[ q.name ]]</td>
				<td ng-repeat="c in q.choices" 
					ng-class="{'selected' : isChoosen(q, c)}"
					ng-click="toggleChoose(q, c)">
				</td>
			</tr>
			<tr ng-if="q.type == 1" class="no-border std-pad">
				<td colspan="[[questionaire.header.rows[0].cols.length || 5]]" 
					class="std-pad"
					ng-repeat="c in q.choices">
					
					<div>
						<span class="col-xs-12">[[ q.name ]]</span>
						<textarea placeholder="[[c.inputs[0].placeholder]]"
								  class="col-xs-12 border"></textarea>
					</div>

				</td>
			</tr>
		</tbody>
	</table>

	<div ng-repeat="q in questionaire.questions" class="col-xs-12">

		<div ng-if="q.type == 10 || q.type == 3" class="std-pad col-xs-12">
			<div class="col-xs-12">
				[[q.name]]
			</div>
			<form>
			<div class="col-xs-6" ng-repeat="c in q.choices">
				<input type="radio" ng-click="toggleChoose(q,c)" name="[[q.name]]">
				<span>[[c.name]]</span>
			</div>
			</form>
		</div>

		<div ng-if="q.type == 2" class="col-xs-12">
			<div class="col-xs-12">
				[[q.name]]
			</div>
		</div>

		<div ng-if="q.type == 4" class="col-xs-12">
			<div class="col-xs-12">
				[[q.name]]
			</div>
			<div class="col-xs-12" ng-repeat="c in q.choices">
				<div class="col-xs-4">
					[[c.name]]
				</div>
				<div class="col-xs-2" ng-repeat="sc in c.subchoices">
					<input type="radio" ng-click="toggleChoose(c,sc)" name="[[c.name]]">
					<span>[[sc.name]]</span>
				</div>
			</div>
		</div>
		
	</div>

	<button type="submit"
			ng-click="submit()"
			style="margin-bottom: 100px"
			class="pull-right std-pad std-margin min-w-100 submit">
		ส่ง
	</button>
</div>
@endsection
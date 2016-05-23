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
			<tr ng-if="q.type != 1 && q.type != 0">
				<td colspan="5">
					[[q.name]]
				</td>
			</tr>
		</tbody>
	</table>

	<button type="submit"
			ng-click="submit()"
			style="margin-bottom: 100px"
			class="pull-right std-pad std-margin min-w-100 submit">
		ส่ง
	</button>
</div>
@endsection
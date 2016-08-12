@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<questionaire-create class="container col-xs-12">
	<h3>สร้างแบบฟอร์ม</h3>
	<hr />
	<div class="table">
		<questionaire-info class="col-xs-12"></questionaire-info>
		<questionaire-criteria class="col-xs-12"></questionaire-criteria>
		<questionaire-questions class="col-xs-12"></questionaire-questions>
	</table>
	<button ng-click="submit()" style="float: right; padding: 5px; margin: 10px">Submit</button>
</questionaire-create>
@endsection
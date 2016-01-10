@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container">
	<h3>เลือกแบบฟอร์มที่ต้องการใช้งาน</h3>
	<div><a href="{{ url('/form/create') }}">สร้างแบบฟอร์ม</a></div>
	<hr />
	<ul class="col-xs-12">
		<li ng-repeat="questionaire in questionaires" class="col-xs-6">
			<a href="{{ url('/questionaire/[[ questionaire.id ]]') }}">
				[[ questionaire.name ]]
			</a>
		</li>
	</ul>
</div>
@endsection

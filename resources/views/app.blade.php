<!DOCTYPE html>
<html lang="en" ng-app="ammart">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<script src="{{ asset('/bower_components/jquery/dist/jquery.js') }}"></script>
	<script src="{{ asset('/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/bower_components/angular/angular.js') }}"></script>
	<script src="{{ asset('/bower_components/angular-route/angular-route.js') }}"></script>
	<script src="{{ asset('/bower_components/ngDialog/js/ngDialog.min.js') }}"></script>

	<script src="{{ asset('/js/ammart.js') }}"></script>
	<script src="{{ asset('/js/questionaire.js') }}"></script>
	<script src="{{ asset('/js/question.js') }}"></script>
	<script src="{{ asset('/js/criterion.js') }}"></script>
	<script src="{{ asset('/js/choice.js') }}"></script>

	<link href="{{ url('bower_components/ngDialog/css/ngDialog.min.css') }}" rel="stylesheet">
	<link href="{{ url('bower_components/ngDialog/css/ngDialog-theme-default.min.css') }}" rel="stylesheet">
	<link href="{{ url('css/app.css') }}" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript">
		angular.module('ammart').constant('CSRF_TOKEN', '{{ csrf_token() }}');
	</script>
</head>
<body>
	<base href="{{ env('APP_URI') }}"></base>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Ammart SDQ/EQ</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">หน้าแรก</a></li>
					<li><a href="{{ url('sdq-eq') }}">แบบฟอร์ม</a></li>
					<li><a href="{{ url('report') }}">รายงาน</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="body" ng-view>
	</div>
</body>
</html>

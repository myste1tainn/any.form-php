<!DOCTYPE html>
<!-- <html lang="en" ng-app="ammart"> -->
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="CSRF_TOKEN" content="{{ csrf_token() }}">
	<title>Ammartpanichanukul</title>
	@include('resource')
</head>
<body>
	<base href="/ammart/">
	<navbar></navbar>
	<my-app></my-app>
</body>
</html>

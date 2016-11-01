<!DOCTYPE html>
<html>
<head>
	<title>LaraBook</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/color-system.css') }}">
	@yield('style')
</head>
<body>
@yield('navbar')

@yield('content')
<script type="text/javascript" src=" {{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src=" {{ asset('js/bootstrap.min.js') }}"></script>
@yield('script')
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<style>
		.container {
			max-width:800px;
		}

		.breadcrumb {
			background:#fff;
			padding:0;
			margin-bottom:40px;
		}


		
	</style>
</head>
<body>
	<br>
	<div class="clearfix">
		<h1 class="pull-right" style="margin-right:40px;"><a href="/home"><i class="fa fa-external-link"></i></a></h1>
	</div>
	<br>
	<br>
	<div class="container">
		@yield('content')
		@yield('main')
	</div>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	@yield('scripts')
</body>
</html>
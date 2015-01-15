<!DOCTYPE html>
<html>
<head>
	<title>Laravel + Sentry Starter App</title>
</head>
<body>
	@if($current_user)
		Signed in as: {{ $current_user->email }}
	@else
		<a href="{{ URL::route('account.signup') }}">Signup</a>
		<a href="{{ URL::route('account.login') }}">Login</a>
	@endif

	@yield('content')
</body>
</html>
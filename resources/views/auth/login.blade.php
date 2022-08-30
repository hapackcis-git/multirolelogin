<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login page</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		.seperator {
			float: left;
			width: 100%;
			border-top: 1px solid #ccc;
			text-align: center;
			margin: 50px 0 0;
		}

		.seperator b {
			width: 40px;
			height: 40px;
			font-size: 16px;
			text-align: center;
			line-height: 40px;
			background: #fff;
			display: inline-block;
			border: 1px solid #e0e0e0;
			border-radius: 50%;
			position: relative;
			top: -22px;
			z-index: 1;
		}

		p {
			float: left;
			width: 100%;
			text-align: center;
			font-size: 16px;
			margin: 0 0 10px;
		}

		.social-icon button {
			font-size: 20px;
			color: white;
			height: 50px;
			width: 50px;
			background: #45aba6;
			border-radius: 60%;
			margin: 0px 10px;
			border: none;
			cursor: pointer;
		}

		button:hover {
			opacity: 0.9;
		}
	</style>
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">

					<div class="cardx fat mt-5">
						<div class="card-body">

							@if(session()->has('error'))
							<div class="alert alert-danger">
								{{ session()->get('error') }}
							</div>
							@endif
							<h4 class="card-title">Login</h4>
							<form method="POST" class="my-login-validation" autocomplete="off" action="{{ route('login') }}">
								@csrf
								<div class="form-group">
									<label for="role">Select Role</label>
									<select id="role" type="role" class="form-control" name="role">
										<option value="" selected>Select Role</option>
										<option value="1">Admin</option>
										<option value="2">User</option>
										<option value="3">Designer</option>

									</select>
									<span class="text-danger">@error('role'){{ $message }}@enderror</span>
								</div>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" autofocus placeholder="Enter email">
									<span class="text-danger">@error('email'){{ $message }}@enderror</span>
								</div>

								<div class="form-group">
									<label for="password">Password
										<a href="{{route('password.request')}}" class="float-right">
											Forgot Password?
										</a>
									</label>
									<input id="password" type="password" class="form-control" name="password" data-eye placeholder="Enter password">
									<span class="text-danger">@error('password'){{ $message }}@enderror</span>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<label for="remember" class="custom-control-label"> {{ __('Remember Me') }}</label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
									<div class="seperator"><b>or</b></div>
									<p>Sign in with your social media account</p>
									<!-- Social login buttons -->
									<div class="social-icon text-center">
										<a href="{{route('login.google')}}"><button type="button"><i class="fa fa-google"></i></button></a>
										<a href="{{route('login.facebook')}}"><button type="button"><i class="fa fa-facebook"></i></button></a>

									</div>

								</div>
								<div class="mt-4 text-center">
									Don't have an account? <a href="{{route('register')}}">Create One</a>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>


	<script src="bootstrap/js/popper.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
	<script src="js/my-login.js"></script>
</body>

</html>
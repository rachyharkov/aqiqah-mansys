<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<style>
		label, p, span{
			color: #9FA2B4;
		}
		.input-group-append i:hover{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center mt-5">
			<div class="col-md-4">
				<div class="card" style="border: 1px solid #DFE0EB;box-sizing: border-box;border-radius: 8px;">
					<div class="card-body">
						<form method="POST" action="{{ route('login') }}">
							@csrf
							<img src="{{asset('img/logo.png')}}" alt="" style="display: block;margin-left: auto;margin-right: auto;">
							<h4 class="text-center">Log In to</h4>
							<h4 class="text-center" style="margin-top: -10px;">Syamil Aqiqah System</h4>
							<p class="text-center" style="font-size: 12px;">Enter your username and password below</p>
							<div class="form-group">
								<label>USERNAME</label>
								<input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">

								@error('username')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
							<label>PASSWORD</label> <span class="float-right" style="font-size: 10px;margin-top: 10px;">Forgot password ?</span>
							<div class="input-group mb-3">
								<input id="txtPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon2"><i class="fa fa-eye" id="toggle_pwd"></i></span>
								</div>
								@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
							<button type="submit" class="btn btn-primary mt-3" style="width: 100%;background: #3751FF;box-shadow: 0px 4px 12px rgba(55, 81, 255, 0.24);border-radius: 8px;">Log In</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
			$("#toggle_pwd").click(function () {
				$(this).toggleClass("fa-eye fa-eye-slash");
				var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
				$("#txtPassword").attr("type", type);
			});
		})
	</script>
</body>
</html>
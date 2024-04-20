<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Modernize Free</title>
		<link rel="shortcut icon" type="image/png" href="{{ asset('assets/src/assets/images/logos/favicon.png') }}" />
		<link rel="stylesheet" href="{{ asset('assets/src/assets/css/styles.min.css') }}" />
	</head>
	<body>
		<!--  Body Wrapper -->
		<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
			data-sidebar-position="fixed" data-header-position="fixed">
			<div
				class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
				<div class="d-flex align-items-center justify-content-center w-100">
					<div class="row justify-content-center w-100">
						<div class="col-md-8 col-lg-6 col-xxl-3">
							<div class="card mb-0">
								<div class="card-body">
                                    @if(Session::get("info"))
                                    <div class="alert alert-primary" role="alert">
                                            {{Session::get("info")}}
                                        </div>
                                    @endif
                                    @if(Session::get("success"))
                                        <div class="alert alert-success" role="alert">
                                            {{Session::get("success")}}
                                        </div>
                                    @endif
                                    @if(Session::get("error"))
                                        <div class="alert alert-danger" role="alert">
                                            {{Session::get("error")}}
                                        </div>
                                    @endif
                                    @yield('content')
									<a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
									<img src="{{ asset('assets/src/assets/images/logos/dark-logo.svg') }}" width="180" alt="">
									</a>
									<p class="text-center">Log in untuk akses inventory</p>
									<form role="form" method="POST" action="{{ url('auth/login') }}">
                                        @csrf
										<div class="mb-3">
											<label for="no_wa" class="form-label">No. Wa</label>
											<input type="text" class="form-control" name="no_wa" id="no_wa" aria-describedby="emailHelp">
										</div>
										<div class="mb-4">
											<label for="password" class="form-label">Password</label>
											<input type="password" name="password" class="form-control" id="password">
										</div>
										<!-- <div class="d-flex align-items-center justify-content-between mb-4">
											<div class="form-check">
												<input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
												<label class="form-check-label text-dark" for="flexCheckChecked">
												Remeber this Device
												</label>
											</div>
											<a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
										</div> -->
                                        <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" type="submit">log In</button>
										<!-- <div class="d-flex align-items-center justify-content-center">
											<p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
											<a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
										</div> -->
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{ asset('assets/src/assets/libs/jquery/dist/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
	</body>
</html>

@extends("include.app")
@section("content")
<a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
<img src="{{ asset('assets/src/assets/images/logos/dark-logo.svg') }}" width="180" alt="">
</a>
<h3 class="text-center">Profil Saya</h3>
<form role="form" method="POST" action="{{ url('auth/update') }}">
	@csrf
	<input type="hidden" name="id" value='{{ Session::get("user")->{"id"} }}'>
    <div class="mb-3">
		<label for="nama" class="form-label">Nama</label>
		<input type="text" class="form-control" name="nama" id="nama" aria-describedby="emailHelp" value='{{ Session::get("user")->{"nama"} }}'>
	</div>
    <div class="mb-3">
		<label for="no_wa" class="form-label">No. WhatsApp</label>
		<input type="text" class="form-control" name="no_wa" id="no_wa" aria-describedby="emailHelp" value='{{ Session::get("user")->{"no_wa"} }}'>
	</div>
    <hr>
	<div class="mb-4">
		<label for="password_new" class="form-label">Password Baru</label>
		<input type="password" class="form-control" name="password_new" id="password_new">
	</div>
    <p>*masukkan password lama jika ingin memperbarui password</p>
    <div class="mb-4">
		<label for="password" class="form-label">Password Lama</label>
		<input type="password" class="form-control" name="password" id="password">
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
    <button class="btn btn-primary w-100 py-8 fs-4 mb-2 rounded-2" type="submit">Update</button>
	<!-- <div class="d-flex align-items-center justify-content-center">
		<p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
		<a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
	</div> -->
</form>

<a class="btn btn-danger w-100 py-8 fs-4 mb-4 rounded-2" href="{{ url('auth/logout') }}" >Log Out</a>
@endsection

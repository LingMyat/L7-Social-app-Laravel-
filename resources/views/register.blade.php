@extends('layout')
@section('content')
<div class="card mb-3">

    <div class="card-body">

      <div class="pt-4 pb-2">
        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
        <p class="text-center small">Enter your personal details to create account</p>
      </div>

      <form class="row g-3 needs-validation" action="{{ route('register') }}" method="post" novalidate>
        @csrf
        <div class="col-12">
          <label for="yourName" class="form-label">Your Name</label>
          <input type="text" name="name" class="form-control" id="yourName" >
          @error('name')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="col-12">
          <label for="yourUsername" class="form-label">Your Email</label>
          <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="text" name="email" class="form-control" id="yourUsername" >

          </div>
          @error('email')
              <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-12">
            <label for="yourEmail" class="form-label">Your Phone</label>
            <input type="number" name="phone" class="form-control" id="yourEmail" >
            @error('phone')
              <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-12">
            <label for="yourEmail" class="form-label">Your Address</label>
            <input type="text" name="address" class="form-control" id="yourEmail" >
            @error('address')
              <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-12">
            <label class="form-label">Your Gender</label>
            <select class="form-select" name="gender" aria-label="Default select example">
                <option value="">Choose your gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @error('gender')
              <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-12">
          <label for="yourPassword" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="yourPassword" >
          @error('password')
              <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="col-12">
            <label for="yourPassword" class="form-label">password_confirmation</label>
            <input type="password" name="password_confirmation" class="form-control" id="yourPassword" >
            @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

        <div class="col-12">
          <button class="btn btn-primary w-100" type="submit">Create Account</button>
        </div>
        <div class="col-12">
          <p class="small mb-0">Already have an account? <a href="{{ route('auth#loginPage') }}">Log in</a></p>
        </div>
      </form>

    </div>
  </div>
@endsection

@extends('User.layout')
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
  </div>
@endsection
@section('content')
    <main id="main" class="main">
        <section class="section profile">
            <div class="row">
              <div class="col-xl-4">

                <div class="card">
                  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    @if ($user->image == Null)
                        <img src="{{ asset('storage/user (3).jpg') }}" alt="Profile" class="rounded-circle">
                    @else
                        <img src="{{ asset('storage/'.$user->image) }}" alt="Profile" class="rounded-circle">
                    @endif
                    <h2>{{ $user->name }}</h2>
                    <h3>{{ $user->job }}</h3>
                    <div class="social-links mt-2">
                      <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                      <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                      <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                      <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-xl-8">

                <div class="card">
                  <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                      <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                      </li>

                      <li class="nav-item {{ auth()->id() ==$user->id ? '' : 'd-none'; }}" id="edit_form">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                      </li>

                      <li class="nav-item {{ auth()->id()==$user->id ? '' : 'd-none'; }}">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                      </li>

                    </ul>
                    <div class="tab-content pt-2">

                      <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <h5 class="card-title">Bio</h5>
                        <p class="small fst-italic">{{ $user->bio }}</p>

                        <h5 class="card-title">Profile Details</h5>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label ">Full Name</div>
                          <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Gender</div>
                            <div class="col-lg-9 col-md-8">{{ $user->gender }}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Job</div>
                          <div class="col-lg-9 col-md-8">{{ $user->job }}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Address</div>
                          <div class="col-lg-9 col-md-8">{{ $user->address }}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Phone</div>
                          <div class="col-lg-9 col-md-8">{{ $user->phone }}</div>
                        </div>

                        <div class="row">
                          <div class="col-lg-3 col-md-4 label">Email</div>
                          <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                        </div>

                      </div>

                      <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                        <!-- Profile Edit Form -->
                        <form action="{{ route('user#profileUpdate',$user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                              <div class="row mb-3">
                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                <div class="col-md-8 col-lg-9">
                                    @if ($user->image == Null)
                                        <img src="{{ asset('storage/user (3).jpg') }}" alt="Profile">
                                    @else
                                        <img src="{{ asset('storage/'.$user->image) }}" alt="Profile">
                                    @endif
                                  <div class="pt-3">
                                    <input type="file" class="form-control" name="image" id="">
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                  </div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="name" type="text" class="form-control" id="fullName" value="{{ old('name',$user->name) }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="about" class="col-md-4 col-lg-3 col-form-label">Bio</label>
                                <div class="col-md-8 col-lg-9">
                                  <textarea name="bio" class="form-control" id="about" style="height: 100px">{{ old('bio',$user->bio) }}</textarea>
                                    @error('bio')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                                <div class="col-md-8 col-lg-9">
                                    <select class="form-select" name='gender' aria-label="Default select example">
                                        <option value="male" {{ $user->gender=='male'?'selected':''; }}>Male</option>
                                        <option value="female"{{ $user->gender=='female'?'selected':''; }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="job" type="text" class="form-control" id="Job" value="{{ old('job',$user->job) }}">
                                    @error('job')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="address" type="text" class="form-control" id="Address" value="{{ old('address',$user->address) }}">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="phone" type="text" class="form-control" id="Phone" value="{{ old('phone',$user->phone) }}">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                <div class="col-md-8 col-lg-9">
                                  <input name="email" type="email" class="form-control" id="Email" value="{{ old('email',$user->email) }}">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <div class="row mb-3">
                                <label for="Email" class="col-md-4 col-lg-3 col-form-label">Role</label>
                                <div class="col-md-8 col-lg-9">
                                  <input type="text" class="form-control" id="Email" value="{{ $user->role }}" disabled>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                              </div>

                              <input type="hidden" name="role" value="{{ $user->role }}">
                              <div class="text-center">
                                <button type="submit" id="edit_btn" class="btn btn-primary">Save Changes</button>
                              </div>
                            </form>
                        <!-- End Profile Edit Form -->

                      </div>


                      <div class="tab-pane fade pt-3" id="profile-change-password">
                        <!-- Change Password Form -->
                        <form>

                          <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="password" type="password" class="form-control" id="currentPassword">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="newpassword" type="password" class="form-control" id="newPassword">
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                            </div>
                          </div>

                          <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                          </div>
                        </form><!-- End Change Password Form -->

                      </div>

                    </div><!-- End Bordered Tabs -->

                  </div>
                </div>

              </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection


@extends('User.layout')
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" action="#">
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
                    <img alt="Profile" class="rounded-circle" src="{{ asset($user->media->image??'assets/theme/default_user/defuser.png') }}" alt="">
                    <h2>{{ $user->name }}</h2>
                    <h3>{{ $user->job }}</h3>

                  </div>
                  <div class="row">
                    <input type="hidden" id="sender_add" value="{{ auth()->id() }}">
                    <input type="hidden" id="reciever_add" value="{{ $user->id }}">

                    @if (!empty($friendRequestOtherProfile))
                        <input type="hidden" id='responseId' value="{{ $friendRequestOtherProfile->id }}">
                    @else
                        <input type="hidden" id='responseId' value="0">
                    @endif
                    @if ($friendRequestOtherProfileValues)
                        <div class="col-8 {{ $user->id==auth()->id()?'d-none':'' }} {{ in_array(auth()->id(),$friendRequestValues)?'d-none':'' }} {{ in_array(auth()->id(),$friendsValues)?'d-none':'' }} mb-3 offset-2">
                            <button class="w-100 btn btn-primary" id="respondFriendBtn">
                                Respond<i class="bi bi-check-lg"></i>
                            </button>
                        </div>
                    @elseif ($friendRequestOtherProfile2Value)
                        <div class="col-8 {{ $user->id==auth()->id()?'d-none':'' }}  {{ in_array(auth()->id(),$friendsValues)?'d-none':'' }} mb-3 offset-2">
                            <a
                            href="javascript:void(0);"
                            title="cancel-request"
                            class="cancel-request-btn"
                            id="cancel_request_btn"
                            data-cancel-request-url="{{ route('user#cancelRequest',$user->id) }}"
                            >
                                <button class="w-100 btn btn-primary" >
                                    Cancel Request<i class="bi bi-arrow-right"></i>
                                </button>
                            </a>
                        </div>
                    @else
                        <div class="col-8 {{ $user->id==auth()->id()?'d-none':'' }} {{ in_array(auth()->id(),$friendRequestValues)?'d-none':'' }} {{ in_array(auth()->id(),$friendsValues)?'d-none':'' }} mb-3 offset-2">
                            <button class="w-100 btn btn-dark" id="addFriendBtn">
                                Add friend+
                            </button>
                        </div>
                    @endif

                  </div>

                </div>
                <div class="card {{ empty($friendRequestValues)? 'd-none' : ''; }} {{ auth()->id()==$user->id ? '' : 'd-none'; }}">
                    <div class="card-header">
                        <h5>Friend Requests</h5>
                    </div>
                    <div class="card-body profile-card pt-4 flex-column d-flex align-items-start gap-2">
                        @foreach ($friendRequest as $friRequest)
                            <div class="mb-2 parent">
                                <input type="hidden" class="reqId" value="{{ $friRequest->id }}">
                                <input type="hidden" class="reciever_con" value="{{ $friRequest->sender_id }}">
                                <a href="{{ route('user#profile',$friRequest->sender->id) }}"><img style="height: 50px;width: 50px;" src="{{ asset($friRequest->sender->media->image??'assets/theme/default_user/defuser.png') }}" alt="Profile" class="rounded-circle"></a>
                                <span>{{ $friRequest->sender->name }}</span>
                                <div class=" ms-5">
                                    <button class="btn btn-primary btn-sm confirm-btn">Confirm</button>
                                    <button class="btn btn-secondary btn-sm delete-btn">Delete</button>
                                </div>
                            </div>
                        @endforeach
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

                      <li class="nav-item ">
                        <button class="nav-link {{ auth()->id()==$user->id ? '' : 'd-none'; }}" data-bs-toggle="tab" data-bs-target="#friends">Friends</button>
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
                                    <img alt="Profile" class="rounded-circle" src="{{ asset(auth()->user()->media->image??'assets/theme/default_user/defuser.png') }}" alt="">
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
                        <form action="{{ route('user#changePassword',$user->id) }}" method="POST">
                            @csrf
                          <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="current_psw" type="password" class="form-control" id="currentPassword">
                              @error('current_psw')
                                <small class="text-danger">{{ $message }}</small>
                              @enderror
                              @if (session('notMatch'))
                                  <small class="text-danger">{{ session('notMatch') }}</small>
                              @endif
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="new_psw" type="password" class="form-control" id="newPassword">
                              @error('new_psw')
                                <small class="text-danger">{{ $message }}</small>
                              @enderror
                            </div>
                          </div>

                          <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                              <input name="confirm_psw" type="password" class="form-control" id="renewPassword">
                              @error('confirm_psw')
                                <small class="text-danger">{{ $message }}</small>
                              @enderror
                            </div>
                          </div>

                          <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                          </div>
                        </form><!-- End Change Password Form -->

                      </div>

                    <div class="tab-pane fade show" id="friends">
                        <div class="card-body profile-card pt-4 flex-column d-flex align-items-start gap-2">
                            @foreach ($friends as $friend)
                                <div class="mb-2 parent">
                                    <input type="hidden" class="user1" value="{{ $friend->sender_id }}">
                                    <input type="hidden" class="user2" value="{{ auth()->id() }}">
                                    <img style="height: 50px;width: 50px;" src="{{ asset($friend->sender->media->image??'assets/theme/default_user/defuser.png') }}" alt="Profile" class="rounded-circle">
                                    <span>{{ $friend->sender->name }}</span>
                                    <div class=" ms-5">
                                        <button class="btn btn-secondary  btn-sm unfriend-btn">Unfriend</button>
                                        <a href="{{ route('message#sendPage',$friend->sender->id) }}">
                                            <button class="btn btn-primary btn-sm message-btn">Message</button>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    </div><!-- End Bordered Tabs -->

                  </div>
                </div>

              </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
@section("script")
    <script>
        $(document).ready(function(){
            $('#addFriendBtn').click(function(){
                $.ajax({
                    type : 'get',
                    url : "/user/addFriend",
                    data : {
                        sender : $('#sender_add').val(),
                        reciever : $('#reciever_add').val()
                    },
                    dataType : 'json',
                    success : function(response){
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }
                })
            })

            $('#cancel_request_btn').click(function(e){
                e.preventDefault()
                let cancelRequestUrl = $(this).data('cancel-request-url');
                $.ajax({
                    type: "get",
                    url: cancelRequestUrl,
                    success: function (response) {
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }
                });
            })

            $('#respondFriendBtn').click(function(){
                $.ajax({
                    type : 'get',
                    url : '/user/respondFriend',
                    data : {
                        id : $('#responseId').val(),
                        sender : $('#reciever_add').val(),
                        reciever : $('#sender_add').val()
                    },
                    dataType : 'json',
                    success : function(response){
                        if (response.status == 'success') {
                            location.reload();
                        }
                    }
                })
            })

            $('.confirm-btn').click(function(){
                $parent = $(this).parents('.parent');
                $id = $parent.find('.reqId').val();
                $recieverCon = $parent.find('.reciever_con').val();
                $.ajax({
                    type : 'get',
                    url : "/user/confirmFri",
                    data : {
                        id : $id,
                        sender : $('#reciever_add').val(),
                        reciever : $recieverCon
                    },
                    dataType : 'json',
                    success : function(response){
                        if (response.status=='success') {
                            location.reload();
                        }
                    }
                })
            })

            $('.delete-btn').click(function(){
                $parent = $(this).parents('.parent');
                $id = $parent.find('.reqId').val();
                $.ajax({
                    type : 'get',
                    url : '/user/deleteFriReq',
                    data : {id:$id},
                    dataType : 'json',
                    success : function(response){
                        if (response.status=='success') {
                            location.reload();
                        }
                    }
                })
            })

            $('.unfriend-btn').click(function(){
                $parent = $(this).parents('.parent');
                $user1 = $parent.find('.user1').val();
                $user2 = $parent.find('.user2').val();
                $.ajax({
                    type : 'get',
                    url : '/user/unFriend',
                    data : {
                        user1 : $user1,
                        user2 : $user2
                    },
                    dataType : 'json',
                    success : function(response){
                        if (response.status=='success') {
                            location.reload();
                        }
                    }
                })
            })
        })
    </script>
@endsection


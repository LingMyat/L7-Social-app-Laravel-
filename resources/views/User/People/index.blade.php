@extends('User.layout')
@section('css')
@endsection
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" action="#" method="get">
            <input type="text" name="search" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>
@endsection
@section('content')
    <main id="main" class="main row">
        @foreach ($users as $user)
            <div class="col-10 mx-auto mx-sm-0 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <a href="{{ route('user#profile',$user->id) }}">
                        <img src="{{ asset($user->media->image ?? 'assets/theme/default_user/defuser.png') }}"
                            class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-2 px-2">
                                <a href="{{ route('user#profile',$user->id) }}">
                                    <h6 class="py-2 card-title">{{ $user->name }}</h6>
                                </a>
                            </div>
                            @if (in_array($user->id, $requestedId))
                                <div class="col-10 mx-auto">
                                    <button
                                    data-url="{{ route('cancelRequest',$user->id) }}"
                                    class="btn w-100 btn-sm btn-secondary cancel-request-btn">Cancel Request<i class="bi bi-arrow-right"></i></button>
                                </div>
                            @elseif (in_array($user->id, $respondId))
                                <div class="col-10 mx-auto">
                                    <button
                                    data-url="{{ route('respondFriend',$user->id) }}"
                                    class="btn w-100 btn-sm btn-primary respond-btn">Respond<i class="bi bi-check-lg"></i></button>
                                </div>
                            @elseif (in_array($user->id, $friendsId))
                                <div class="col-6">
                                    <button
                                    data-url="{{ route('unfriend',$user->id) }}"
                                    class="btn w-100 btn-sm btn-secondary unfriend-btn">Unfriend</button>
                                </div>
                                @php
                                    $userArr = [$user->name, auth()->user()->name];
                                    sort($userArr);
                                @endphp
                                <div class="col-6">
                                    <a style="height: 32px" href="/user/messenger/{{ $user->id }}?roomName={{ $userArr[0].$userArr[1] }}" class="btn w-100 btn-sm btn-blue">
                                        Message
                                    </a>
                                </div>
                            @else
                                <div class="col-10 mx-auto">
                                    <button
                                     data-url='{{ route('addFriend',$user->id) }}'
                                     class="btn w-100 btn-sm btn-dark add-btn">Add Friend+</button>
                                </div>
                            @endif


                        </div>
                        {{-- <p class="card-text">{{ Str::words($post->content,12,'...')}}</p> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </main><!-- End #main -->
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            let ajaxCall = (para)=>{
                $.ajax({
                    type: "POST",
                    url: para,
                    success: function (response) {
                        if (response.status=='Success') {
                            window.location.reload();
                        }
                    }
                });
            }

            $('.add-btn').click(function (e) {
                e.preventDefault();
                ajaxCall($(this).data('url'));
            });

            $('.cancel-request-btn').click(function (e) {
                e.preventDefault();
                ajaxCall($(this).data('url'));
            });

            $('.respond-btn').click(function (e) {
                e.preventDefault();
                ajaxCall($(this).data('url'));
            });

            $('.unfriend-btn').click(function (e) {
                e.preventDefault();
                ajaxCall($(this).data('url'));
            });

        });
    </script>
@endsection

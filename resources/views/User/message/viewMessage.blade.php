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

              <div class="col-sm-10 offset-sm-1">

                <div class="card">
                  <div class="card-body p-3">
                    <input type="hidden" id="msgId" value="{{ $message->id }}">
                        <div class="mb-2">
                            <a href="{{ route('message#index') }}" class="btn btn-default"><i class="bi bi-arrow-left"></i> Back</a>
                        </div>
                        <div class=" pl-2">
                                <a href="{{ route('user#profile',$message->sender->id) }}">
                                    <img style="height: 50px;width: 50px;" src="{{ asset($message->sender->media->image??'assets/theme/default_user/defuser.png') }}" alt="Profile" class="rounded-circle">
                                </a>
                                <b>{{ $message->sender->name }}</b>
                            <small class=" float-end pt-2">{{ $message->created_at->format('d/m/Y h:i A') }}</small>
                        </div>
                        <div class="p-5">
                            <p class="mb-4 fst-italic">
                                {{ $message->content }}
                            </p>
                            <a class="btn btn-outline-secondary rounded-5 px-3 py-1" href="{{ route('message#sendPage',$message->sender_id) }}"><i class="bi bi-arrow-90deg-left"></i> Reply</a> to <small><b>{{ $message->sender->email }}</b></small>


                        </div>
                  </div>
                </div>

              </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
@section('script')
    <script>
        $(document).ready(function(){

            $.ajax({
                type : "get",
                url : '/message/read',
                data : {id : $('#msgId').val()},
                dataType : 'json',

            })
        })
    </script>
@endsection


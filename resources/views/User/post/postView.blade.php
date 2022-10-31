@extends('user.layout')
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
        <section class="section">
            <div class="row">
                <div class="col-10 p-1 offset-1">
                    <div class="card">
                        <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-12 mt-3 d-flex gap-3 align-items-center">
                                @if ($post->user->image == Null)
                                    <img style="width: 40px;height:40px;" class="rounded-circle" src="{{ asset('storage/user (3).jpg') }}" alt="">
                                 @else
                                    <img style="width: 40px;height:40px;" class="rounded-circle" src="{{ asset('storage/'.$post->user->image) }}" alt="">
                                @endif
                                <div class="">{{ $post->user->name }}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class=" card-title">{{ $post->title }}</h3>
                                <h6>{{ $post->created_at->format('d/m/Y h:i A') }}</h6>
                            </div>
                          </div>
                          <p class="card-text">{{ $post->content }}</p>
                          <hr>
                          <div class="p-0">
                            <h4>Comments</h4>
                            @foreach ($comments as $comment)
                                <div class="p-2">
                                    <img style="width: 35px;height:35px;" class="rounded-circle" src="{{ asset('storage/'.$comment->user->image) }}" alt="">
                                    <h6 class=" d-inline-block ms-1"><b>{{ $comment->user->name }}</b></h6>
                                    <small class="float-end">{{ $comment->created_at }}</small>
                                    <small class="px-4 d-block"><b>-</b><i>{{ $comment->content }}</i></small>
                                </div>
                            @endforeach

                            <form action="{{ route('user#commentCreateComment') }}" method="POST">
                                @csrf
                                <div class="input-group p-2">
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="text" name="content" class="form-control form-control-sm" placeholder="Enter to post comment">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-caret-up-fill"></i>
                                    </button>
                                </div>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection

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
                <div class="col-3 mb-3 offset-9">
                    <a href="{{ route('admin#postList') }}" class="btn btn-danger {{ auth()->user()->role=='admin'?'':'d-none' }}">Back to Admin</a>
                    <a href="{{ route('user#postCreatePage') }}" class="{{ auth()->user()->role=='admin'?'':'float-end' }} btn btn-success">Add Post+</a>
                </div>
                @foreach ($posts as $post)
                    <div class="col-4">
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
                                <div class=" col-8 px-2">
                                    <h5 class="py-2 card-title">{{ $post->title }}</h5>
                                </div>
                                <div class="col-4 pt-2 px-5 d-flex gap-2 justify-content-end @if ($post->user_id !== auth()->id()) d-none @endif">
                                    <a href="{{ route('user#postEdit',$post->id) }}"><i class="bi bi-pencil"></i></a>
                                    <a href="{{ route('user#postDelete',$post->id) }}"><i class="bi bi-trash"></i></a>
                                </div>
                              </div>
                              <p class="card-text">{{ Str::words($post->content,12,'...')}}</p>
                            </div>
                          </div>

                    </div>
                @endforeach
            </div>
            <div class="">{{ $posts->links() }}</div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection

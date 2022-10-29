@extends('layout.master')
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
                                    <img style="width: 40px;height:40px;" class="rounded-circle" src="{{ asset('storage/'.$user->image) }}" alt="">
                                @endif
                                <div class="">{{ $post->user->name }}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class=" card-title">{{ $post->title }}</h3>
                                <h6>{{ $post->created_at->format('d/m/Y h:i A') }}</h6>
                            </div>
                          </div>
                          <p class="card-text">{{ $post->content }}</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection

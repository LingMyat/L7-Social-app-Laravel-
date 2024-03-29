@extends('user.layout')
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
  </div>
@endsection
@section('content')
@php
    $images = $post->gallery;
@endphp
    <main id="main" class="main">
        <section class="section" id="section">
            <div class="row">
                <div class="col-10 p-1 offset-1">
                    <div class="card">
                              {{-- <h5 class="card-title">With indicators</h5> --}}

                              <!-- Slides with indicators -->
                              <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @for ($i=0;$i<count($images);$i++)
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}" class="carousel-button {{ $i == 0 ? ' active' : '' }}" aria-current="{{ $i == 0 ? 'true' : '' }}" aria-label="Slide {{ $i+1 }}"></button>
                                    @endfor
                                </div>
                                <div class="carousel-inner">
                                    @foreach ($images as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? ' active' : '' }} " data-bs-interval="3500" >
                                            <img src="{{ $image->image }}" class="d-block w-100" alt="...">
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Next</span>
                                </button>

                              </div><!-- End Slides with indicators -->
                        <div class="card-body">
                          <div class="row">
                            <div class="col-12 mt-3 d-flex gap-3 align-items-center">
                                <img style="width: 40px;height:40px;" class="rounded-circle" src="{{ asset($post->user->media->image??'assets/theme/default_user/defuser.png') }}" alt="">
                                <div class=""><b>{{ $post->user->name }}</b></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class=" card-title">{{ $post->title }}</h3>
                                <h6>{{ $post->created_at->diffForHumans() }}</h6>
                            </div>
                          </div>
                          <p class="card-text">{{ $post->content }}</p>
                          <hr>
                          <div class="p-0">
                            <h4>Comments</h4>
                            @foreach ($comments as $comment)
                                <div class="p-2">
                                    <img style="width: 35px;height:35px;" class="rounded-circle" src="{{ asset($comment->user->media->image??'assets/theme/default_user/defuser.png') }}" alt="">
                                    <h6 class=" d-inline-block ms-1"><b>{{ $comment->user->name }}</b></h6>
                                    <small class="float-end">{{ $comment->created_at->diffForHumans() }}</small>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="px-4"><b>-</b><i>{{ $comment->content }}</i></small>
                                        <div id="cmtParent" class="{{ $comment->user_id == auth()->id()?'':'d-none' }}">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-sm btn-secondary " type="button" data-bs-toggle="dropdown" >
                                                  <i class="bi bi-three-dots"></i>
                                                </button>
                                                <div style="width: 300px" class="dropdown-menu p-2 shadow bg-secondary-light">
                                                    <form class="p-2 " action="{{ route('user#commentUpdate',$comment->id) }}" method="post">
                                                        @csrf
                                                        <input name="content" type="text" value="{{ $comment->content }}" class="mb-3 form-control form-control-sm cmtEdit">
                                                        <button class=" btn btn-primary float-end btn-sm update-btn">
                                                            save
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <input type="hidden" class="cmt_id" value="{{ $comment->id }}">
                                            <button class="btn btn-sm btn-danger delete-btn">
                                                <i class="ri-delete-bin-6-fill"></i>
                                            </button>
                                        </div>
                                    </div>
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
@section('script')
    <script>

        $(document).ready(function(){
            let status = "{{ session('ment') }}";
            let scrollFunc = ()=>{
                window.scrollTo(0,document.body.scrollHeight);
            };
            if (status == true) {
                scrollFunc();
            }
            $('.delete-btn').click(function(){
                $parent = $(this).parents('#cmtParent');
                $id = $parent.find('.cmt_id').val();
                $.ajax({
                    type : 'get',
                    url : '/comment/delete',
                    data : {id:$id},
                    dataType : 'json',
                    success : function(response){
                        location.reload();
                    }
                })
            })

            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: "/people/forget-ment",
                });
            }, 100);
        });
    </script>
@endsection

@extends('user.layout')
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="get" action="{{ route('user#home') }}">
            <input type="text" name="search" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
  </div>
@endsection
@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-3 mb-3 offset-lg-9">
                    <a href="{{ route('admin#postList') }}" class="btn btn-danger {{ auth()->user()->role=='admin'?'':'d-none' }}">Back to Admin</a>
                    <a href="{{ route('user#postCreatePage') }}" class="{{ auth()->user()->role=='admin'?'':'float-end' }} btn btn-success">Add Post+</a>
                </div>
                <input type="hidden" id="currentUser" value="{{ auth()->id() }}">
                @foreach ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <a href="{{ route('user#postView',$post->id) }}">
                                <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" alt="...">
                            </a>
                            <div class="card-body">
                              <div class="row">
                                <div class="col-12 mt-3 d-flex gap-3 justify-content-between align-items-center">
                                    <div class="">
                                        <a href="{{ route('user#profile',$post->user_id) }}">
                                            <img style="width: 40px;height:40px;" class="rounded-circle" src="{{ asset($post->user->media->image??'assets/theme/default_user/defuser.png') }}" alt="">
                                        </a>
                                    <b><i><div class=" d-inline">{{ $post->user->name }}</div></i></b>
                                    </div>

                                    <div style="cursor: pointer" class="parent">
                                        <input type="hidden" class="postId" value="{{ $post->id }}">
                                        <input type="hidden" class="reactCount" value="{{ reactCount($post->id) }}">
                                        <i class="{{ checkLiked($post->id)?'d-none':''; }} bi bi-heart like_btn"></i>
                                        <i class="{{ checkLiked($post->id)?'':'d-none'; }} bi bi-heart-fill text-danger unlike_btn"></i> <b><span class="react-count-container">{{ reactCount($post->id) }}</span></b>
                                    </div>
                                </div>

                                <div class=" col-8 px-2">
                                    <a href="{{ route('user#postView',$post->id) }}">
                                        <h5 class="py-2 card-title">{{ $post->title }}</h5>
                                    </a>
                                </div>
                                <div class="col-4 pt-2 px-1 d-flex gap-1 justify-content-end @if ($post->user_id !== auth()->id()) d-none @endif">
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
            <div class="">{{ $posts->appends(request()->query())->links() }}</div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.like_btn').click(function(){
                $parent = $(this).parents('.parent');
                $postId = $parent.find('.postId').val();
                $reactCount = $parent.find('.reactCount').val();
                $reactCountContainer = $parent.find('.react-count-container');
                $unLikeBtn = $parent.find('.unlike_btn');
                $(this).addClass('d-none');
                $unLikeBtn.removeClass('d-none');
                $.ajax({
                    type : 'get',
                    url : '/like',
                    data : {
                        post_id : $postId,
                        user_id : $('#currentUser').val()
                    },
                    dataType : 'json',
                    success : function(response){
                        if (response.status == 'success') {
                            $parent.find('.reactCount').val(Number($reactCount)+1);
                            $reactCountContainer.html($parent.find('.reactCount').val());
                        }
                    }
                });
            });

            $('.unlike_btn').click(function(){
                $parent = $(this).parents('.parent');
                $postId = $parent.find('.postId').val();
                $reactCount = $parent.find('.reactCount').val();
                $reactCountContainer = $parent.find('.react-count-container');
                $LikeBtn = $parent.find('.like_btn');
                $(this).addClass('d-none');
                $LikeBtn.removeClass('d-none');
                $.ajax({
                    type : 'get',
                    url : '/unLike',
                    data : {
                        post_id : $postId,
                        user_id : $('#currentUser').val()
                    },
                    dataType : 'json',
                    success : function(response){
                        if (response.status == 'success') {
                            $parent.find('.reactCount').val($reactCount-1);
                            $reactCountContainer.html($parent.find('.reactCount').val());
                        }
                    }
                });
            });
        })
    </script>
@endsection

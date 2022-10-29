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
                <div class="col col-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">Post Lists</h5>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin#postCreatePage') }}" class=" mt-2 float-end btn btn-default">
                                     + Add-Post
                                </a>
                            </div>
                          </div>
                          <!-- Default Table -->
                          <table class="table">
                            <thead>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">Created_at</th>
                                <th scope="col">Action</th>
                            </thead>
                            <tbody >
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin#postView',$post->id) }}"><img style="width: 100px;height:60px;" class=" rounded-1" src="{{ asset('storage/'.$post->image) }}" alt=""></a>
                                        </td>
                                        <td class=" pt-4"><a href="{{ route('admin#postView',$post->id) }}" class="text-decoration-none text-black">{{ $post->title }}</a></td>
                                        <td class=" pt-4">{{ Str::words($post->content,4,'...') }}</td>
                                        <td class=" pt-4">{{ $post->created_at->format('d/m/Y') }}</td>
                                        <td class=" pt-3">
                                            <a href="{{ route('admin#postView',$post->id) }}" class="btn btn-primary">View</a>
                                            <a href="{{ route('admin#postEdit',$post->id) }}" class="btn btn-warning">Edit</a>
                                            <a href="{{ route('admin#postDelete',$post->id) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                          <!-- End Default Table Example -->
                        </div>
                    </div>
                    <div class="">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection

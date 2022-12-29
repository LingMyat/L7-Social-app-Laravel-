@extends('user.layout')
@section('css')
    <style>
        p{
            font-size: 25px !important;
        }
    </style>
@endsection
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
                <div class="col-10 offset-1">
                    <div class="card">
                        <div class="card-body py-3">
                          <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">Create Post</h5>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('user#home') }}" class=" float-end btn btn-light">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>
                          </div>
                          <!-- Vertical Form -->
                          <form action="{{ route('user#postCreate') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="row g-3 mb-3">
                                <div class="row col-6">
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Title</label>
                                        <input type="text" value="{{ old('title') }}" name='title' class="form-control" id="inputNanme4">
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                      </div>
                                      <div class="col-12">
                                        <label for="inputPassword4" class="form-label">Content</label>
                                        <textarea name="content" id="" class="form-control" cols="30" rows="8">{{ old('content') }}</textarea>
                                        @error('content')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                      </div>
                                </div>
                                  <div class="row col-6">
                                    <div class="col-12">
                                        <label for="image" class="form-label">Image</label>
                                        {{-- <input class="form-control" name='image' type="file" id="formFile"> --}}
                                        <input type="file" class="form-control" name="image" id="image" data-max-file-size="1000K"
                                        data-allowed-file-extensions='["png", "PNG", "jpg", "JPG", "jpeg", "JPEG"]' required>
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if (session('imgNeed'))
                                        <small class="text-danger">{{ session('imgNeed') }}</small>
                                        @endif
                                      </div>
                                  </div>
                            </div>
                            <button type="submit" class=" float-end btn btn-primary">Create</button>
                          </form><!-- Vertical Form -->

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
        $(document).ready(function () {
            $('#image').dropify()
        });
    </script>
@endsection

@extends('user.layout')
{{-- #6658dd --}}
@section('css')
    <style>
        .file-preview .fileinput-remove {
            border: none;
        }

        .parsley-errors-list>li {
            color: #f1556c;
            font-size: 14px;
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
                <div class="col-11 mx-auto">
                    <div class="card">
                        <div class="card-body py-3">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">Create Post</h4>
                                </div>

                            </div>
                            <!-- Vertical Form -->
                            <form class="parsley-examples" action="{{ route('user#postCreate') }}" id=""
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6 col-12 row">
                                        <div class="col-12">
                                            <label for="inputNanme4" class="form-label"><b>Title</b></label>
                                            <input type="text" value="{{ old('title') }}" name='title'
                                                class="form-control mb-2" id="inputNanme4" required>
                                            {{-- @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror --}}
                                            <label for="inputPassword4" class="form-label d-block"><b>Content</b></label>
                                            <textarea name="content" id="" class="form-control mb-2" cols="30" rows="8" required>{{ old('content') }}</textarea>
                                            {{-- @error('content')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 row">
                                        <div class="col-12">
                                            <label for="formFile" class="form-label"><b>Images</b></label>
                                            {{-- <h5 class="text-uppercase mt-0 bg-light p-2">Product Gallery</h5> --}}
                                            <input type="file" name="image_galleries[]" id="image_galleries"
                                                data-allowed-file-extensions='["png", "PNG", "jpg", "JPG", "jpeg", "JPEG"]'
                                                multiple>
                                            {{-- <input class="form-control" name='image' type="file" id="formFile"> --}}
                                            @error('image')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            @if (session('imgNeed'))
                                                <small class="text-danger">{{ session('imgNeed') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class=" text-center">
                                    <a href="{{ route('user#home') }}" class=" btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class=" btn btn-primary">Create</button>
                                </div>
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
        $(document).ready(function() {
            $('#image_galleries').fileinput({
                maxFileSize: 2000,
            }).on('fileselect', function(event, numFiles, label) {
                $('button[type="button"].kv-file-zoom').remove();
                $('.fileinput-upload-button').remove();
            });
            $('.parsley-examples').parsley();
            // gt, gte, lt, lte, notequalto extra validators
            var parseRequirement = function(requirement) {
                if (isNaN(+requirement))
                    return parseFloat(jQuery(requirement).val());
                else
                    return +requirement;
            };

            // Greater than or equal to validator
            window.Parsley.addValidator('gte', {
                validateString: function(value, requirement) {
                    return parseFloat(value) >= parseRequirement(requirement);
                },
                priority: 32
            });
        });
    </script>
@endsection

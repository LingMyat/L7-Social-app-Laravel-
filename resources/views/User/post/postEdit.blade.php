@extends('user.layout')
@section('css')
    <style>
        p {
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
                <div class="col-11 mx-auto">
                    <div class="card">
                        <div class="card-body py-3">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Edit Post</h5>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('user#home') }}" class=" float-end btn btn-light">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                            <!-- Vertical Form -->
                            <form action="{{ route('user#postUpdate', $post->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <div class="row g-3 mb-3">
                                    <div class="row col-6">
                                        <div class="col-12">
                                            <label for="inputNanme4" class="form-label">Title</label>
                                            <input type="text" value="{{ old('title', $post->title) }}" name='title'
                                                class="form-control mb-2" id="inputNanme4" required>
                                            {{-- @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror --}}
                                            <label for="inputPassword4" class="form-label">Content</label>
                                            <textarea name="content" id="" class="form-control mb-2" cols="30" rows="8" required>{{ old('content', $post->content) }}</textarea>
                                            {{-- @error('content')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror --}}
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="col-12">
                                            <label for="formFile" class="form-label">Images</label>
                                            <input type="file" name="image_galleries[]" id="image_galleries"
                                                data-allowed-file-extensions='["png", "PNG", "jpg", "JPG", "jpeg", "JPEG"]'
                                                multiple>
                                                <input type="hidden" id="delete_image_url" value="{{ url('post/media') }}">
                                            {{-- @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror --}}
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class=" float-end btn btn-primary">Update</button>
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
            let galleries = @json($post->gallery);
            console.log(galleries);
            let previewImages = new Array();
            let previewConfig = new Array();

            $.each( galleries, function( key, v ) {
                previewImages.push(v.image);
                var image_media_id_class = 'image-media-'+v.id;
                previewConfig.push({frameClass: image_media_id_class, downloadUrl: v.image, key: key});
            });

            $("#image_galleries").fileinput({
                initialPreview: previewImages,
                initialPreviewAsData: true,
                initialPreviewConfig: previewConfig,
                overwriteInitial: false,
                maxFileSize: 2000,
            }).on('fileselect', function(event, numFiles, label) {
                removeAndAddClass();
            }).on('filecleared', function(event, numFiles, label) {
                removeAndAddClass();
            });

            removeAndAddClass();

            $.each( galleries, function( key, v ) {
                var image_media_id = v.id;
                var image_media_delete_url = $('#delete_image_url').val() + '/' + image_media_id;
                var html = '<a class="kv-file-remove btn btn-sm btn-kv btn-default btn-outline-danger" data-id="' + image_media_id
                + '"href="' + image_media_delete_url + '" data-toggle="modal" data-target="#deleteFormModal">'+
                '<i class="ri-delete-bin-6-fill"></i>'+
                '</a>';
                $('.image-media-'+image_media_id).find('.kv-file-remove').remove();
                $('.image-media-'+image_media_id).find('.file-footer-buttons').append(html);
            })

        });
        function removeAndAddClass() {
            $('.kv-file-remove i').removeClass('glyphicon glyphicon-trash').addClass('ri-delete-bin-6-fill');
            $('.kv-file-download i').removeClass('glyphicon glyphicon-trash').addClass('bi bi-cloud-arrow-down');
            $('button[type="button"].kv-file-zoom').remove();
            $('.fileinput-upload-button').remove();
        }
    </script>
@endsection

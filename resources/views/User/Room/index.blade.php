@extends('User.layout')
@section('css')
    <style>
        p {
            font-size: 14px;
        }
    </style>
@endsection
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" action="#" method="get">
            <input type="text" name="search" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>
@endsection
@section('content')
    <main id="main" class="main row">
        <div class="card col-10 mx-auto">
            <div class="card-header">
                <h3 class="d-inline-block">Rooms</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm float-end btn-blue" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    +Create Room
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Room</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('room#store') }}" method="POST" id="room_form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="">Room Name</label>
                                        <input type="text" name="name" placeholder="Enter Room Name"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="">Room Image</label>
                                        <input id="room_image" type="file" name="image" data-max-file-size="1M"
                                            data-allowed-file-extensions="jpeg jpg png" required class="form-control">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                                <button type="submit" form="room_form" class="btn btn-info">submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-bodey">
                <div class="row p-1">
                    @foreach ($rooms as $room)
                        <div class="my-2 col-md-6">
                            <!-- Card with an image on left -->
                            <div class="card mx-1 mb-3">
                                <div class="row m-1 g-0">
                                <div class="col-md-6">
                                    <img src="{{ asset($room->media->image) }}" class="img-fluid rounded-start" alt="{{ $room->name }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                    <h5 class="card-title">Room-Name : {{ $room->name }}</h5>
                                    {{-- <div>{{ $room->admin->name }}</div> --}}
                                        <a href="/room/live-chat?roomId={{ $room->id }}" class="btn btn-md-sm float-end btn-danger">Enter</a>
                                    </div>
                                </div>
                                </div>
                            </div><!-- End Card with an image on left -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </main><!-- End #main -->
@endsection
@section('script')
    j
    <script>
        $(document).ready(function() {
            $('#room_image').dropify();
        });
    </script>
@endsection

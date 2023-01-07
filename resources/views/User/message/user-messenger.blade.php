@extends('User.layout')
@section('css')
@endsection
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
        $profile = auth()->user()->media->image ?? 'http://127.0.0.1:8000/assets/theme/default_user/defuser.png';
    @endphp
    <main id="main" class="main row">
        <div class="card col-10 mx-auto">
            <div class="card-header">
                <div>
                    <img style="height: 45px;width: 45px;"
                        src="{{ asset($user->media->image ?? 'assets/theme/default_user/defuser.png') }}" alt="Profile"
                        class="rounded-circle">
                    <b>{{ $user->name }}</b>
                    {{-- <h5>
                        {{ $user->name }}
                    </h5> --}}
                </div>
                {{-- <h3>{{ $room->name }}</h3> --}}
            </div>
            <div class="card-bodey">
                <div class="" style="height: 60vh; overflow-y: scroll; overflow-x:hidden;" id="mainContainer">
                    <div id="message_Container">
                        @foreach ($messages as $message)
                            @if ($message->sender->id == auth()->user()->id)
                                <div class="mb-1 px-2 d-flex gap-2 me-4">
                                    <small class="row ms-auto msg-content ">
                                        <b class="col-8 bg-info-light mt-1 ms-auto rounded-1">
                                            <i>
                                                <small>{{ $message->content }}</small>
                                            </i>
                                        </b>
                                    </small>
                                </div>
                            @else
                                <div class="mb-1 px-2 d-flex gap-2">
                                    <small class="row msg-content">
                                        <b class="col-8 bg-secondary-light py-1 ms-2 mt-1 rounded-1">
                                            <i>
                                                <small>{{ $message->content }}</small>
                                            </i>
                                        </b>
                                    </small>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="input-group">
                    <input class="form-control" type="text" id="msg">
                    <button class="btn btn-primary" data-url="{{ route('user#storeMessenger') }}" id="send-btn">send <i
                            class="bx bxl-telegram"></i></button>
                </div>
            </div>
        </div>

    </main><!-- End #main -->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const message_container = document.getElementById('message_Container');
            $id = "{{ auth()->user()->id }}";
            $name = "{{ auth()->user()->name }}";
            $profile = "{{ $profile }}";
            $roomName = "{{ request('roomName') }}";
            $reciever_id = "{{ $user->id }}"
            let ip_address = '127.0.0.1';
            let socket_port = '3000';
            let socket = io(ip_address + ':' + socket_port);

            let scrollFunc = ()=>{
                $('#mainContainer').animate({scrollTop: $('#message_Container').height()},0);
            }
            joinRoomData = {
                name: $name,
                profile: $profile,
                roomId: $roomName,
            }
            socket.emit('joinRoom', joinRoomData);

            $('#send-btn').click(function(e) {
                e.preventDefault();
                if ($('#msg').val() == '') {
                    return
                }

                data = {
                    id: $id,
                    reciever_id: $reciever_id,
                    name: $name,
                    profile: $profile,
                    message: $('#msg').val(),
                }

                $.ajax({
                    type: "post",
                    url: $(this).data('url'),
                    data: data,
                    dataType: "json",
                });
                socket.emit('message', data)
            });

            socket.on('message', (data) => {

                sender = `
                <div class="mb-1 px-2 d-flex gap-2 me-4">
                                    <small class="row ms-auto msg-content ">
                                        <b class="col-8 bg-info-light mt-1 ms-auto rounded-1">
                                            <i>
                                                <small>${data.message}</small>
                                            </i>
                                        </b>
                                    </small>
                                </div>
                `;
                reciever = `
                <div class="mb-1 px-2 d-flex gap-2">
                                    <small class="row msg-content">
                                        <b class="col-8 bg-secondary-light py-1 ms-2 mt-1 rounded-1">
                                            <i>
                                                <small>${data.message}</small>
                                            </i>
                                        </b>
                                    </small>
                                </div>
                `;

                if (data.id == $id) {
                    message_container.innerHTML += sender;
                } else {
                    message_container.innerHTML += reciever
                }
                $('#msg').val('');
                scrollFunc()
            })
            scrollFunc();

        });
    </script>
@endsection

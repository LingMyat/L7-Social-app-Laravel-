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
                <h3>{{ $room->name }}</h3>
            </div>
            <div class="card-bodey">
                <div class="" style="min-height: 60vh">
                    <div id="messages_from_database">
                        @foreach ($messages as $message)
                            @if ($message->user->id == auth()->user()->id)
                                <div class=" text-end m-1 mb-2">
                                    <small class=''>
                                        <div class="text-end">
                                            <b style="max-width: 320px"
                                                class='d-inline-block p-1 px-2 rounded-1 bg-info-light mx-3 rounded-1 text-start'>
                                                <i class="">
                                                    <small>{{ $message->message }}</small>
                                                </i>
                                            </b>
                                        </div>
                                        @foreach ($message->childs as $sameUserMsg)
                                            <div class="text-end mt-1">
                                                <b style="max-width: 320px"
                                                    class='d-inline-block  p-1 px-2 rounded-1 bg-info-light mx-3 rounded-1 text-start'>
                                                    <i class="">
                                                        <small>{{ $sameUserMsg->message }}</small>
                                                    </i>
                                                </b>
                                            </div>
                                        @endforeach
                                    </small>
                                </div>
                            @else
                                <div class="mb-2 px-2 d-flex gap-2">
                                    <img style="height: 25px;width: 25px;" src="{{ $message->user->media->image }}"
                                        alt="Profile" class="rounded-circle">
                                    <small class="row msg-content">
                                        <b class="col-12">{{ $message->user->name }}</b>
                                        <b class="col-8 bg-secondary-light ms-2 mt-1 rounded-1">
                                            <i>
                                                <small>{{ $message->message }}</small>
                                            </i>
                                        </b>
                                        @foreach ($message->childs as $sameUserMsg)
                                            <b class="col-8 bg-secondary-light ms-2 mt-1 rounded-1">
                                                <i>
                                                    <small>{{ $sameUserMsg->message }}</small>
                                                </i>
                                            </b>
                                        @endforeach
                                    </small>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div id="message_Container">

                    </div>
                    {{-- <div class="mb-2 px-2 d-flex gap-2">
                        <img style="height: 25px;width: 25px;"
                            src="{{ asset(auth()->user()->media->image ?? 'assets/theme/default_user/defuser.png') }}"
                            alt="Profile" class="rounded-circle">
                        <small class="row">
                            <b class="col-12">{{ auth()->user()->name }}</b>
                            <b class="col-7 bg-secondary-light ms-2 mt-1 rounded-1">
                                <i>
                                    <small>Hello What Are You Doing?huyu cuurhcue euihdurhch</small>
                                </i>
                            </b>
                        </small>
                    </div> --}}
                </div>
            </div>
            <div class="card-footer">
                <div class="input-group">
                    <input class="form-control" type="text" id="msg">
                    <button class="btn btn-primary" data-url="{{ route('liveChat#storeMessage') }}" id="send-btn">send <i
                            class="bx bxl-telegram"></i></button>
                </div>
            </div>
        </div>

    </main><!-- End #main -->
@endsection
@section('script')
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"
        integrity="sha384-/KNQL8Nu5gCHLqwqfQjA689Hhoqgi2S84SNUxC3roTe4EhJ9AfLkp8QiQcU8AMzI" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            // const {roomId} = Qs.parse(location.search,{
            //     ignoreQueryPrefix : true
            // });

            $id = "{{ auth()->user()->id }}"
            $name = "{{ auth()->user()->name }}";
            $profile = "{{ $profile }}";
            $roomId = "{{ request('roomId') }}";
            let current_id;
            let current_sender_id_from_emit_server;
            const message_container = document.getElementById('message_Container');
            let ip_address = '127.0.0.1';
            let socket_port = '3000';
            let socket = io(ip_address + ':' + socket_port);

            joinRoomData = {
                name: $name,
                profile: $profile,
                roomId: $roomId,
            }

            socket.emit('joinRoom', joinRoomData);

            socket.on('joining', name => {
                message_container.innerHTML +=
                    `<small class="text-center d-block my-1"><b>${name} has joined the room.</b></small>`;
            })

            socket.on('leaving', name => {
                message_container.innerHTML +=
                    `<small class="text-center d-block my-1"><b>${name} has left the room.</b></small>`;
            })
            // socket.on('connection');
            $('#send-btn').click(function(e) {
                e.preventDefault();
                if ($('#msg').val() == '') {
                    return
                }

                data = {
                    id: $id,
                    roomId: $roomId,
                    name: $name,
                    profile: $profile,
                    message: $('#msg').val(),
                    parent: false
                }

                if (current_id == $id) {
                    data.parent = true;
                }

                $.ajax({
                    type: "get",
                    url: $(this).data('url'),
                    data: data,
                    dataType: "json",
                });
                socket.emit('message', data)
            });

            socket.on('message', (data) => {

                sender = `
                <div class="text-end m-1 mb-2">
                        <small class='text-start'>
                            <div class="text-end">
                                                <b style="max-width: 320px" class ='d-inline-block p-1 px-2 rounded-1 bg-info-light mx-3 rounded-1 text-start'>
                                                    <i class="">
                                                        <small>${data.message}</small>
                                                </i>
                                                </b>
                                            </div>
                        </small>
                </div>
                `;
                reciever = `
                <div class="mb-2 px-2 d-flex gap-2">
                        <img style="height: 25px;width: 25px;"
                            src="${data.profile}"
                            alt="Profile" class="rounded-circle">
                        <small class="row msg-content">
                            <b class="col-12">${data.name}</b>
                            <b class="col-8 bg-secondary-light ms-2 mt-1 rounded-1">
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
                    if (current_id == data.id) {
                        let msg_content = document.getElementsByClassName('msg-content');
                        msg_content[msg_content.length - 1].innerHTML += `
                            <b class="col-7 bg-secondary-light ms-2 mt-1 rounded-1">
                                        <i>
                                            <small>${data.message}</small>
                                        </i>
                                    </b>
                            `;
                    } else {
                        message_container.innerHTML += reciever
                    }
                }
                $('#msg').val('');
                current_id = data.id;
            })
        });
    </script>
@endsection

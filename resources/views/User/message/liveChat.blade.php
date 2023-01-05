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
                <div class="" style="min-height: 60vh" id="message_Container">

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
                    <button class="btn btn-primary" id="send-btn">send <i class="bx bxl-telegram"></i></button>
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
            const {roomId} = Qs.parse(location.search,{
                ignoreQueryPrefix : true
            });

            $id = "{{ auth()->user()->id }}"
            $name = "{{ auth()->user()->name }}";
            $profile = "{{ $profile }}";
            let current_id;
            const message_container = document.getElementById('message_Container');
            let ip_address = '127.0.0.1';
            let socket_port = '3000';
            let socket = io(ip_address + ':' + socket_port);

            joinRoomData = {
                name : $name,
                profile : $profile,
                roomId : roomId,
            }

            socket.emit('joinRoom',joinRoomData);

            socket.on('joining',name=>{
                message_container.innerHTML += `<small class="text-center d-block my-1"><b>${name} has joined the room.</b></small>`;
            })

            socket.on('leaving',name=>{
                message_container.innerHTML += `<small class="text-center d-block my-1"><b>${name} has left the room.</b></small>`;
            })
            // socket.on('connection');
            $('#send-btn').click(function(e) {
                e.preventDefault();
                if ($('#msg').val() == '') {
                    return
                }
                data = {
                    id: $id,
                    name: $name,
                    profile: $profile,
                    message: $('#msg').val(),
                }
                socket.emit('message', data)
            });

            socket.on('message', (data) => {

                sender = `
                <div class="text-end m-1">
                        <small class=''>
                            <b class =' p-1 px-2 rounded-1 bg-info-light mx-3'>
                                <i class="">
                                ${data.message}
                            </i>
                            </b>
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
                            <b class="col-7 bg-secondary-light ms-2 mt-1 rounded-1">
                                <i>
                                    <small>${data.message}</small>
                                </i>
                            </b>
                        </small>
                    </div>
                `;

                    if (data.id == $id) {
                        message_container.innerHTML +=  sender;
                    } else {
                        if (current_id == data.id) {
                            let msg_content = document.getElementsByClassName('msg-content');
                            msg_content[msg_content.length-1].innerHTML += `
                            <b class="col-7 bg-secondary-light ms-2 mt-1 rounded-1">
                                        <i>
                                            <small>${data.message}</small>
                                        </i>
                                    </b>
                            `;
                            } else {
                                message_container.innerHTML +=  reciever
                            }
                    }
                $('#msg').val('');
                current_id = data.id;
            })
        });
    </script>
@endsection

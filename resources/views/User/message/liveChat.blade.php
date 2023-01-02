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
                <h3>Live-Chat</h3>
            </div>
            <div class="card-bodey">
                <div class="" style="min-height: 60vh" id="message_Container">
                    {{-- <div class="mb-2 px-2">
                        <img style="height: 35px;width: 35px;"
                            src="{{ asset(auth()->user()->media->image ?? 'assets/theme/default_user/defuser.png') }}"
                            alt="Profile" class="rounded-circle">
                        <small><b>{{ auth()->user()->name }}</b></small>
                        <div>
                            <b class="ms-4">
                                <i>
                                    Hello What Are You Doing?
                                </i>
                            </b>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="card-footer">
                <div class="input-group">
                    <input class="form-control" type="text" id="msg">
                    <button class="btn btn-primary" id="send-btn">send</button>
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
            $id = "{{ auth()->user()->id }}"
            $name = "{{ auth()->user()->name }}";
            $profile = "{{ $profile }}";
            const message_container = document.getElementById('message_Container');
            let ip_address = '127.0.0.1';
            let socket_port = '3000';
            let socket = io(ip_address + ':' + socket_port);
            // socket.on('connection');
            $('#send-btn').click(function(e) {
                e.preventDefault();
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
                    <div class=" p-1 d-inline-block alert alert-info">
                        <i class="mx-3">
                            ${data.message}
                        </i>
                    </div>
                </div>
                `;
                reciever = `
                <div class="mb-1 px-2">
                        <img style="height: 35px;width: 35px;"
                            src="${data.profile}"
                            alt="Profile" class="rounded-circle">
                        <small><b>${data.name}</b></small>
                        <div>
                            <b class="ms-4">
                                <i>
                                    ${data.message}
                                </i>
                            </b>
                        </div>
                    </div>
                `;
                message_container.innerHTML += data.id == $id ? sender : reciever;
                $('#msg').val('');
            })
        });
    </script>
@endsection

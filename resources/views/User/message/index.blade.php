@extends('User.layout')
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
  </div>
@endsection
@section('content')
    <main id="main" class="main">
        <section class="section profile">
            <div class="row">

              <div class="col-sm-10 offset-sm-1">

                <div class="card">
                  <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                      <li class="nav-item">
                        <button class="nav-link position-relative active" data-bs-toggle="tab" data-bs-target="#inbox"><i class="bi bi-inbox-fill"></i> Inbox
                            <span class="{{ count($unRead)==0?'d-none':''; }} position-absolute top-0 start-100 translate-middle badge rounded bg-danger">
                                {{ count($unRead) }}
                            </span>
                        </button>
                      </li>

                      <li class="nav-item" id="edit_form">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#composeMessage"><i class="bi bi-pencil"></i> Compose</button>
                      </li>

                      <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#sentMessage"><i class="bi bi-cursor"></i> Sent</button>
                      </li>


                    </ul>
                    <div class="tab-content pt-2">

                      <div class="tab-pane fade pt-3 show active inbox" id="inbox">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>From</td>
                                    <td>Content</td>
                                    <td>Time</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allMessages as $message)
                                    <tr class=" ">
                                        <td>
                                            @if ($message->sender->image == Null)
                                                <img style="width: 50px;height:50px;" class="rounded-circle me-1" src="{{ asset('storage/user (3).jpg') }}" alt="">
                                            @else
                                                <img style="width: 50px;height:50px;" class="rounded-circle me-1" src="{{ asset('storage/'.$message->sender->image) }}" alt="">
                                            @endif
                                            {{ $message->sender->name }}
                                        </td>
                                        <td class="pt-4">{{ Str::words($message->content, 8, '...') }}</td>
                                        <td class="pt-4">{{ $message->created_at->format('h:i A') }}</td>
                                        <td class="pt-4 position-relative">
                                            <a href="{{ route('message#view',$message->id) }}" class="">View</a> /
                                            <a href="{{ route('message#delete',$message->id) }}" class="text-danger">Delete</a>
                                            <span class="{{ $message->status<>'unread'?'d-none':''; }} translate-middle position-absolute top-0 start-100  p-2 bg-danger border border-light rounded-circle">
                                              </span>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                      </div>

                      <div class="tab-pane fade  pt-3" id="composeMessage">

                        <!-- send message form -->
                        <form action="{{ route('message#send') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <select class="form-select" name="reciever_id" aria-label="Default select example">
                                    <option value="">Select friend</option>
                                    @foreach ($friends as $friend)
                                        <option value="{{ $friend->sender_id }}">
                                            {{ $friend->sender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea name="content" placeholder="Subject.." class="form-control" id="" rows="9"></textarea>
                            </div>
                            <input type="hidden" name="sender_id" value="{{ auth()->id() }}">
                            <button class=" rounded-5 btn btn-primary float-end" type="submit">Send <i class="bi bi-arrow-up"></i></button>
                        </form>
                        <!-- End Profile Edit Form -->

                      </div>


                      <div class="tab-pane fade pt-3" id="sentMessage">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>From</td>
                                    <td>Content</td>
                                    <td>Time</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sentMessage as $message)
                                    <tr class=" ">
                                        <td>
                                           To : {{ $message->reciever->name }}
                                        </td>
                                        <td class="">{{ Str::words($message->content, 8, '...') }}</td>
                                        <td class="">{{ $message->created_at->format('h:i A') }}</td>
                                        <td class="">
                                            <a href="{{ route('message#viewMyMessage',$message->id) }}" class="">View</a> /
                                            <a href="{{ route('message#delete',$message->id) }}" class="text-danger">Delete</a>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                      </div>

                    </div><!-- End Bordered Tabs -->

                  </div>
                </div>

              </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection


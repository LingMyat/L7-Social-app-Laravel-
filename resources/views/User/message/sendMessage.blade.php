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
                  <div class="card-body p-3">
                        <div class="mb-2">
                            <a onclick="history.back()" class="btn btn-default"><i class="bi bi-arrow-left"></i> Back</a>
                        </div>
                        <div class="">
                            <form action="{{ route('message#send') }}" method="POST">
                                @csrf
                                    <div class="mb-3">
                                        <input type="hidden" name="reciever_id" value="{{ $reciever->id }}">

                                    </div>
                                    <div class=" pl-2 mb-3">

                                        @if ($reciever->image == Null)
                                            <a href="{{ route('user#profile',$reciever->id) }}">
                                                <img style="width: 50px;height:50px;" class="rounded-circle me-1" src="{{ asset('storage/user (3).jpg') }}" alt="">
                                            </a>
                                        @else
                                        <a href="{{ route('user#profile',$reciever->id) }}">
                                            <img style="width: 50px;height:50px;" class="rounded-circle me-1" src="{{ asset('storage/'.$reciever->image) }}" alt="">
                                        </a>
                                        @endif
                                            <b>{{ $reciever->name }}</b>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="content" placeholder="Subject.." class="form-control" id="" rows="9"></textarea>
                                    </div>
                                    <input type="hidden" name="sender_id" value="{{ auth()->id() }}">
                                    <button class=" rounded-5 btn btn-primary float-end" type="submit">Send <i class="bi bi-arrow-up"></i></button>
                            </form>
                        </div>
                  </div>
                </div>

              </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection


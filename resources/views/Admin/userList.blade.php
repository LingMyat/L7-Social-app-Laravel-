@extends('layout.master')
@section('search')
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="get" action="{{ route('admin#userList') }}">
            <input type="text" name="search" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
  </div>
@endsection
@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col col-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">User Lists</h5>

                          <!-- Default Table -->
                          <table class="table">
                            <thead>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Job</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Action</th>
                            </thead>
                            <tbody >
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            @if ($user->image == Null)
                                                <img style="width: 50px;height:50px;" class="rounded-circle" src="{{ asset('storage/user (3).jpg') }}" alt="">
                                            @else
                                                <img style="width: 50px;height:50px;" class="rounded-circle" src="{{ asset('storage/'.$user->image) }}" alt="">
                                            @endif
                                        </td>
                                        <td class=" pt-3">{{ $user->name }}</td>
                                        <td class=" pt-3">{{ $user->job }}</td>
                                        <td class=" pt-3">{{ $user->phone }}</td>
                                        <td class=" pt-3">{{ $user->address }}</td>
                                        <td class=" pt-3">{{ $user->gender }}</td>
                                        <td>
                                            <a href="{{ route('admin#profile',$user->id) }}" class="btn btn-primary">View</a>
                                            <a href="" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>

                          <!-- End Default Table Example -->
                        </div>
                    </div>
                    <div class="">{{ $users->links() }}</div>
                </div>
            </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection

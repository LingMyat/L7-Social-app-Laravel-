<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>L7-Social</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/assets/img/favicon.png" rel="icon">
  <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    @include('User.share.header-css')
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">L7-Social</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    @yield('search')

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->


        <li class="nav-item dropdown pe-5">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img alt="Profile" class="rounded-circle" src="{{ asset(auth()->user()->media->image??'assets/theme/default_user/defuser.png') }}" alt="">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
                <img style="width: 50px;height:50px;" alt="Profile" class="rounded-circle" src="{{ asset(auth()->user()->media->image??'assets/theme/default_user/defuser.png') }}" alt="">
              <h6>{{ auth()->user()->name }}</h6>
              <span>{{ auth()->user()->job }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('user#profile',auth()->id()) }}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
                {{-- <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn text-black btn-link text-decoration-none" type="submit"><i class="bi bi-box-arrow-right"></i> <span class="mx-3">Sign Out</span></button>
                </form> --}}
                <a class="dropdown-item d-flex align-items-center" href="{{ route('auth#logout')}}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Log out</span>
                </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link active" href="{{ route('user#home') }}">
            <i class="ri-article-line"></i>
          <span>Posts</span>
        </a>
      </li><!-- End Blank Page Nav -->
      @php
          $unRead = messageNoti();
      @endphp
    <li class="nav-item">
        <a class="nav-link position-relative active" href="{{ route('message#index') }}">
            <i class="bi bi-chat-square-text-fill"></i>
            <span>Message</span>
            <span class="{{ count($unRead)==0?'d-none':''; }} position-absolute top-0 start-100 translate-middle badge rounded bg-danger">
                {{ count($unRead) }}
            </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('message#liveChat') }}">
            <i class="ri-chat-voice-fill"></i>
          <span>Live-Chat-Groups</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->

  @yield('content')

  <!-- ======= Footer ======= -->
  <footer style="margin-top: auto !important;" id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @include('User.share.footer-script')

</body>

</html>

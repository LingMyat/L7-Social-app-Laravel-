  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


  <!-- Template Main CSS File -->
  <link href="/assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/theme/NiceSelect/css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/theme/bootstrap-fileinput/fileinput.min.css') }}">
  @yield('css')
  <style>
      .form-control:focus {
          border: 1px solid #0000000;
          box-shadow: 0 0 0 0;
      }

      .btn-primary {
          background: #6658dd;
          border: 1px solid #6658dd;
      }

      .btn-primary:hover {
          background: #4938d7;
          border: 1px solid #4938d7;
      }

      .btn-success,
      .btn-success:hover {
          background: #1abc9c;
          border: 1px solid #1abc9c;
      }

      .btn-danger,
      .btn-danger:hover {
          background: #f1556c;
          border: 1px solid #f1556c;
      }

      .btn-blue {
          color: #fff;
          background-color: #4a81d4;
          border-color: 1px solid #4a81d4;
      }

      .btn-blue:hover {
          color: #fff;
          background-color: #306cc8;
          border-color: 1px solid #2d67be;
      }

      .badge {
          z-index: 100;
      }

      body {
          display: flex;
          flex-direction: column;
          min-height: 100vh;
      }
  </style>

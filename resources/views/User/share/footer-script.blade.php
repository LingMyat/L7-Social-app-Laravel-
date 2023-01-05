@include('Share.flash-session')
<!-- Vendor JS Files -->

<script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/chart.js/chart.min.js"></script>
<script src="/assets/vendor/echarts/echarts.min.js"></script>
<script src="/assets/vendor/quill/quill.min.js"></script>
<script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="/assets/vendor/php-email-form/validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset("assets/libs/dropify/dropify.min.js") }}"></script>


<!-- Template Main JS File -->
<script src="/assets/js/main.js"></script>
<script src="{{ asset('assets/theme/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ asset('assets/theme/NiceSelect/js/jquery.nice-select.js') }}"></script>
<script src="{{ asset('assets/libs/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('assets/theme/bootstrap-fileinput/fileinput.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/qs/6.11.0/qs.min.js" integrity="sha512-/l6vieC+YxaZywUhmqs++8uF9DeMvJE61ua5g+UK0TuHZ4TkTgB1Gm1n0NiA86uEOM9JJ6JUwyR0hboKO0fCng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('script')



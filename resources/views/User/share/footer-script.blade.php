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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/libs/dropify/dropify.min.js') }}"></script>


<!-- Template Main JS File -->
<script src="/assets/js/main.js"></script>
<script src="{{ asset('assets/theme/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ asset('assets/theme/NiceSelect/js/jquery.nice-select.js') }}"></script>
<script src="{{ asset('assets/libs/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('assets/theme/bootstrap-fileinput/fileinput.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"
    integrity="sha384-/KNQL8Nu5gCHLqwqfQjA689Hhoqgi2S84SNUxC3roTe4EhJ9AfLkp8QiQcU8AMzI" crossorigin="anonymous">
</script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            // Pusher.logToConsole = true;

            // var pusher = new Pusher('59ba2eab2eb53ae64ed6', {
            //     cluster: 'ap1'
            // });

            // var channel = pusher.subscribe('private.{{ auth()->id() }}');
            // channel.bind('private', function(res) {
            //     toastr.success(JSON.stringify(res.message), {timeOut: 4000},{positionClass: "toast-top-center"})
            // });
        //end
    });
</script>
@yield('script')

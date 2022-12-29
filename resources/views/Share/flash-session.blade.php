<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
   const Toast = swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
   })
</script>

@if ($message = Session::get('success'))
   <script>
      Toast.fire({
         icon: 'success',
         title: "{{ $message }}"
      })
   </script>
@endif

@if ($message = Session::get('error'))
   <script>
      Toast.fire({
         icon: 'error',
         title: "{{ $message }}"
      })
   </script>
@endif
@if ($errors->any())
   @php
   $html = '';
   @endphp
   @foreach ($errors->all() as $error)
      {{ $html .= '<li>' . $error . '</li>' }}
   @endforeach
   <script>
      Toast.fire({
         icon: 'error',
         title: '<ul>' + "{!! $html !!}" + '</ul>'
      })
   </script>
@endif

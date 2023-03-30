@if(session('swal-error'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                title: 'Error!',
                 text: '{{ session('swal-error') }}',
                 icon: 'error',
                 confirmButtonText: 'Ok',
      });
        });
    </script>

@endif

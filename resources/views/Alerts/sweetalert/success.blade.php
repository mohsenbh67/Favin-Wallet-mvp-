@if(session('swal-success'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                title: 'Task Completed Successfully',
                 text: '{{ session('swal-success') }}',
                 icon: 'success',
                 confirmButtonText: 'Ok',
      });
        });
    </script>

@endif

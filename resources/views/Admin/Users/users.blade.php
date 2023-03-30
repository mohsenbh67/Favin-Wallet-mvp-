@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Users </title>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row" style="display: block">

                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <!-- /.card -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title text-danger">All Users</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>National Code</th>
                                                        <th>Activation</th>
                                                        <th>User Type</th>
                                                        <th>Created_At</th>
                                                        <th>Wallet Counts</th>
                                                        <th>Setting</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($users as $key => $user)
            
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $user->full_name ?? '-' }}</td>
                                                        <td>{{ $user->email ?? '-' }}</td>
                                                        <td>{{ $user->national_code ?? '-' }}</td>
                                                        <td>{{ $userActivations[$user->activation] }}</td>
                                                        <td>{{ $userTypes[$user->user_type] }}</td>
                                                        <td>{{ $user->created_at }}</td>
                                                        <td>{{ $user->wallets()->count() ?? '0' }}</td>
                                                        <td class="width-24-rem text-left">
                                                            <a href="{{ route('admin.users.edit', $user->slug) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit </a>
                                                            <a href="{{ route('admin.users.wallets', $user->slug) }}" class="btn btn-warning btn-sm"><i class="fa fa-wallet"></i> Wallets </a>
                                                        </td>
                                            
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>National Code</th>
                                                        <th>Activation</th>
                                                        <th>User Type</th>
                                                        <th>Created_At</th>
                                                        <th>Wallet Counts</th>
                                                        <th>Setting</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->
                    </section>



                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
<script>

    $(document).ready(function () {

        $('#users').addClass('active');

                });
    
    </script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>

@endsection
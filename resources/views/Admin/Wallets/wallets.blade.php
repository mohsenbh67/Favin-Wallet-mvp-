@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Wallets </title>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Wallets</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Wallets</li>
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
                                            <h3 class="card-title text-danger">All Wallets</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Last Transaction</th>
                                                        <th>Created_At</th>
                                                        <th>Setting</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($wallets as $key => $wallet)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $wallet->title }}</td>
                                                            <td>{{ Str::limit($wallet->description, 20) }}</td>
                                                            <td>{{ $wallet->status($wallet->status) }}</td>
                                                            <td>{{ $wallet->amount }}</td>
                                                            <td>{{ $wallet->user->lastWalletTransaction($wallet->id, $wallet->user->id)->published_at ?? '-' }}
                                                            </td>
                                                            <td>{{ $wallet->created_at }}</td>
                                                            @if (Route::current()->getName() === 'admin.users.wallets')
                                                                <td><a href="{{ route('admin.users.transactions', $wallet->slug) }}"
                                                                        class="btn btn-warning btn-sm"><i
                                                                            class="fa fa-history"></i> Transactions </a>
                                                                </td>
                                                            @else
                                                                <td class="width-24-rem text-left">
                                                                    <a href="{{ route('admin.wallets.edit', $wallet->slug) }}"
                                                                        class="btn btn-primary btn-sm"><i
                                                                            class="fa fa-edit"></i> Edit </a>
                                                                    <a href="{{ route('admin.transactions.deposit', $wallet->slug) }}"
                                                                        class="btn btn-success btn-sm"><i
                                                                            class="fa fa-money-bill"></i> Deposit</a>
                                                                    <a href="{{ route('admin.transactions.withdraw', $wallet->slug) }}"
                                                                        class="btn btn-danger btn-sm"><i
                                                                            class="fa fa-money-bill-wave"></i> Withdraw</a>
                                                                    <a href="{{ route('admin.transactions.transactions', $wallet->slug) }}"
                                                                        class="btn btn-warning btn-sm"><i
                                                                            class="fa fa-history"></i> Transactions </a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Last Transaction</th>
                                                        <th>Created_At</th>
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
        $(document).ready(function() {

            $('#wallets').addClass('active');

        });
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

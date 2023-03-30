@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Wallet Transactions </title>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Wallet Transactions</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Wallet Transactions</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $user->depositCount($wallet->id) ?? '0' }}</h3>

                                <p>Deposit Transactions Count</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <p class="small-box-footer">Updated at {{ $user->lastTransaction($user->id)->created_at ?? 'now'}}  <i class="fas fa-clock mx-2"></i></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $user->withdrawCount($wallet->id) ?? '0' }} </h3>

                                <p>Withdraw Transactions Count</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <p class="small-box-footer">Updated at {{ $user->lastTransaction($user->id)->created_at ?? 'now'}} <i class="fas fa-clock mx-2"></i></p>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $user->totalWalletAmount($wallet->id)->amount }} $</h3>

                                <p>Totall Amount</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <p class="small-box-footer">Updated at {{ $user->lastTransaction($user->id)->created_at ?? 'now'}} <i class="fas fa-clock mx-2"></i></p>

                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row" style="display: block">

                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <!-- /.card -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title text-danger">Active Wallets</h3>
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
                                                        <th>Created At</th>
                                                        <th>Publish At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($transactions as $key => $transaction)
            
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $transaction->title }}</td>
                                                        <td>{{ Str::limit($transaction->description, 20) }}</td>
                                                        <td>{{ $transaction->status($transaction->status) }}</td>
                                                        <td>{{ $transaction->amount }}</td>
                                                        <td>{{ $transaction->created_at }}</td>
                                                        <td>{{ $transaction->published_at }}</td>
                                            
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
                                                        <th>Created At</th>
                                                        <th>Publish At</th>
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
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>

@endsection
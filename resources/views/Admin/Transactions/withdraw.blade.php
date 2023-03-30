@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Create Withdraw Transaction </title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Withdraw Transaction</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.wallets.wallets') }}">Wallets</a></li>
                        <li class="breadcrumb-item active">Create Withdraw Transaction</li>
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

            <!-- /.row -->
            <!-- Main row -->
            <div class="row" style="display: block">

                <section class="content">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <!-- /.card -->
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">

                                        <p class="login-box-msg">Create Withdraw Transaction</p>
                                        <form action="{{ route('admin.transactions.store', $wallet->slug)}}" method="post">
                                            @csrf
                        <input type="hidden" class="form-control form-control-sm" name="status" value="withdraw">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('title') }}"
                                                    name="title" placeholder="Title">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-pencil-alt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('title')
                                            <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </p>
                                        @enderror
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"  value="{{ old('description') }}"
                                                    name="description" placeholder="Description">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-pencil-alt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('description')
                                            <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </p>
                                        @enderror
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"  value="{{ old('amount') }}"
                                                    name="amount" placeholder="Amount">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-pencil-alt"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('amount')
                                            <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </p>
                                        @enderror
                                        <div class="input-group date mb-3" id="reservationdatetime" data-target-input="nearest">
                                            <input type="text" name="published_at" class="form-control datetimepicker-input" data-target="#reservationdatetime" value="{{ old('published_at') }}" placeholder="Publish Date"/>
                                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                            @error('published_at')
                                            <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </p>
                                        @enderror

                                            <div class="row" style="justify-content: center">
                                                <!-- /.col -->
                                                <div class="">
                                                    <button type="submit" class="btn btn-primary btn-block">Create</button>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </form>
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
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

</script>


@endsection
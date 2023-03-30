@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Edit Wallet </title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Wallet</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.wallets.wallets') }}">Wallets</a></li>
                        <li class="breadcrumb-item active">Edit Wallet</li>
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

                                        <p class="login-box-msg">Edit Wallet</p>
                                        <form action="{{ route('admin.wallets.update', $wallet->slug) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('title', $wallet->title) }}"
                                                    name="title">
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
                                                <input type="text" class="form-control"  value="{{ old('description', $wallet->description) }}"
                                                    name="description">
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
                                            
                                                <select name="status" class="form-control form-control-sm" id="status">
                                                    <option value="0" @if(old('status', $wallet->status) == 0) selected @endif>notActive</option>
                                                    <option value="1" @if(old('status', $wallet->status) == 1) selected @endif>Active</option>
                                                    <option value="2" @if(old('status', $wallet->status) == 2) selected @endif>Archived</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-wallet"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('status')
                                                <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>
                                                        {{ $message }}
                                                    </strong>
                                                </p>
                                            @enderror
                                            <div class="row" style="justify-content: center">
                                                <!-- /.col -->
                                                <div class="">
                                                    <button type="submit" class="btn btn-primary btn-block">Edit</button>
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


@endsection
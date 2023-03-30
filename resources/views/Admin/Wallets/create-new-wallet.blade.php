@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Create New Wallet </title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create New Wallet</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.wallets.wallets') }}">Wallets</a></li>
                        <li class="breadcrumb-item active">Create New Wallet</li>
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

                                        <p class="login-box-msg">Create New Wallet</p>
                                        <form action="{{ route('admin.wallets.store') }}" method="post">
                                            @csrf
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
                                            
                                                <select name="status" class="form-control form-control-sm" id="status">
                                                    <option value="0" @if(old('status') == 0) selected @endif>notActive</option>
                                                    <option value="1" @if(old('status') == 1) selected @endif>Active</option>
                                                    <option value="2" @if(old('status') == 2) selected @endif>Archived</option>
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

    $(document).ready(function () {

        $('#createwallet').addClass('active');

                });
    
    </script>

@endsection
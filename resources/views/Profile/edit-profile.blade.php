@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Edit Profile </title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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

                                        <p class="login-box-msg">Edit Profile</p>
                                        <form action="{{ route('admin.update-profile') }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('first_name', $user->first_name) }}"
                                                    name="first_name">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('first_name')
                                            <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </p>
                                        @enderror
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"  value="{{ old('last_name', $user->last_name) }}"
                                                    name="last_name">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('last_name')
                                            <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </p>
                                        @enderror
                                            <div class="input-group mb-3">
                                                <input type="email" class="form-control" value="{{ old('email', $user->email) }}"
                                                    name="email">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-envelope"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('email')
                                                <p class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>
                                                        {{ $message }}
                                                    </strong>
                                                </p>
                                            @enderror
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"  value="{{ old('national_code', $user->national_code ?? 'National Code') }}"
                                                    name="national_code">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('national_code')
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
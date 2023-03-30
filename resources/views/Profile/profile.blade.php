@extends('Layouts.Admin.master')

@section('head-tag')
    <title> Profile </title>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
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

                        
                                      <h3 class="profile-username text-center">{{ $user->full_name }}</h3>
                        
                                      <p class="text-muted text-center">Active User</p>
                        
                                      <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                          <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                                        </li>
                                        <li class="list-group-item">
                                          <b>National Code</b> <a class="float-right">{{ $user->national_code ?? '-' }}</a>
                                        </li>

                                      </ul>
                        
                                      <a href="{{ route('admin.edit-profile') }}" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
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
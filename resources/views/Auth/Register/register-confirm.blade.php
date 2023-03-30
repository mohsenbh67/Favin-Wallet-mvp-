@extends('Layouts.Auth.Register.master')

@section('head-tag')
<style>
    #resend-otp{
        font-size: 1rem;
    }
</style>
    <title>Registration Confirm Page</title>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a class="h1"><b>Favin</b>Wallet</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form action="{{ route('register-confirm', $token) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Code" value=""
                        name="otp">
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
                <div class="row" style="justify-content: center">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Confirm</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <section id="resend-otp" class="d-none">
                <a href="{{ route('register-resend-otp', $token) }}" class="text-decoration-none text-primary">Resend code </a>
            </section>
            <section id="timer"></section>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
@endsection

@section('script')

@php
    $timer = ((new \Carbon\Carbon($otp->created_at))->addMinutes(5)->timestamp - \Carbon\Carbon::now()->timestamp) * 1000;
@endphp

<script>

   var countDownDate = new Date().getTime() + {{ $timer }};
    var timer = $('#timer');
    var resendOtp = $('#resend-otp');

    var x = setInterval(function(){

        var now = new Date().getTime();

        var distance = countDownDate - now;

        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if(minutes == 0){
            timer.html('Resend again ' + seconds + 'Seconds')
        }
        else{
            timer.html('Resend again ' + minutes + ' minutes and  ' + seconds + 'seconds');
        }
        if(distance < 0)
        {
            clearInterval(x);
            timer.addClass('d-none');
            resendOtp.removeClass('d-none');
        }

    }, 1000)





</script>

@endsection

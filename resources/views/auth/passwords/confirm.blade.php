@extends('layouts.single-page-app')

@section('site_title', 'Confirm Password')

@section('bg_image', 'bg-login-page')

@section('content')
    <div class="row" style="margin-top: 8vh;">
        <div class="col-12 col-sm-4 offset-sm-1 col-md-3 offset-md-1 col-lg-3 offset-lg-1">
            <div class="mb-4 text-center">
                <a href="{{ route('dashboard.index') }}"><img src="{{ asset('img/logo.svg') }}" alt="" width="80"></a>
            </div>
            <!-- /.mb-4 -->

            <div class="mb-4 text-center">
                <small class="text-muted">{{ __('Please confirm your password before continuing.') }}</small>
            </div>
            <!-- /.mb-4 -->

            @include('errors.validation')

            {!! Form::open(['url' => route('account.password.confirm'), 'method' => 'post']) !!}
            <div class="input-group mb-3">
                {!! Form::password('password', ['class' => 'form-control form-control-lg login-form-control', 'required', 'placeholder' => 'Password', 'autocomplete' => 'current-password']) !!}

                <div class="input-group-append">
                    <span class="input-group-text"><img src="{{ asset('img/password.svg') }}" height="20" alt=""></span>
                </div>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
                {!! Form::submit('Confirm Password', ['class' => 'btn btn-purple btn-block']) !!}
            </div>
            <!-- /.form-group -->

            <div class="form-group">
                <a href="{{ route('account.password.request') }}" class="text-deep-purple">{{ __('Forgot Your Password?') }}</a>
            </div>
            <!-- /.form-group -->

            {!! Form::close() !!}
        </div>
        <!-- /.col-4 -->
    </div>
    <!-- /.row -->
@endsection

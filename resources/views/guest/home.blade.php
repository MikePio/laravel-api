@extends('layouts.guest')
@section('content')
    <div class="container overflow-auto p-5 text-center" style="max-height: calc(100vh - 70.24px);">
        {{-- <h1>Home guest</h1> --}}
        <h1>Welcome!</h1>
        <h2>Here you can manage your dashboard</h2>
        <h2>Register or log in to access as admin</h2>
        <a class="btn btn-primary m-3 text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
        <a class="btn btn-primary m-3 text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
    </div>
@endsection

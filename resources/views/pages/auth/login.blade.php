@extends('layouts.auth-master')
@section('title', 'Login')
@section('style')
@endsection

@section('container')
    <form class="user" action="{{ route('doLogin') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" name="username" class="form-control form-control-user" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
    </form>
@endsection

@section('script')
@endsection

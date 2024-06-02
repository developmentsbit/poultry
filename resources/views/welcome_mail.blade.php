@extends('email_template')

@section('content')
    Welcome {{ $user->name }}, Please use below credentials to login:
    <br>
    <br>
    @if(isset($data['member_id']))
    Member ID: <strong>{{ $data['member_id'] }}</strong>
    @endif
    <br>
    Username: <strong>{{ $data['email'] }}</strong>
    <br>
    Password: <strong>{{ $data['password'] }}</strong>
    <br>
    <br>
@endsection

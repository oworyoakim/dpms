@extends('master')
@section('title','Users')
@section('content')
    <app-users :roles="{{$roles}}"></app-users>
@endsection

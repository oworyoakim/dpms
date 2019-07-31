@extends('master')
@section('title','Users Roles')
@section('content')
    <app-roles :permissions="{!! json_encode($permissions) !!}"></app-roles>
@endsection

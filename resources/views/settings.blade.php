@extends('master')
@section('title','Settings')
@section('content')
    <app-settings :settings="{{$settings}}"></app-settings>
@endsection

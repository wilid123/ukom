@extends('layout.mainlayout')

@section('title', 'Profile')

@section('content')

<h1>Welcome</h1>

<x-rent-log-table :rentlog='$rent_logs' />
@endsection
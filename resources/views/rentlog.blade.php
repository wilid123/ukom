@extends('layout.mainlayout')

@section('title', 'Rent Log')

@section('content')

<h2>Peminjaman</h2>

<x-rent-log-table :rentlog='$rent_logs' />

@endsection
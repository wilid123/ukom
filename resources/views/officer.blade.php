@extends('layout.mainlayout')

@section('title', 'Officer')

@section('content')
        <h1>List Users</h1>

        <div class="mt-5 d-flex justify-content-end">
                <a href="/registerAdmin" class="btn btn-secondary me-3">Add Users</a>
                <a href="/user-banned" class="btn btn-danger me-3">View Banned Data</a>
                <a href="/registered-users" class="btn btn-primary">New Registered Users</a>
        </div>

        <div class="mt-5">
        @if (session('status'))
                <div class="alert alert-success">
                        {{ session('status') }}
                </div>
        @endif
        </div>
        
        <div class="mt-5">
        @if (session('status-warning'))
                <div class="alert alert-warning">
                        {{ session('status-warning') }}
                </div>
        @endif
        </div>

        <div class="mt-5">
        @if (session('status-danger'))
                <div class="alert alert-danger">
                        {{ session('status-danger') }}
                </div>
        @endif
        </div>
        
        <div class="my-5 container shadow p-3 bordr">
                <table class="table">
                        <thead>
                                <tr>
                                        <td>No</td>
                                        <td>Username</td>
                                        <td>Phone</td>
                                        <td>Action</td>
                                </tr>
                        </thead>
                        <tbody>
                                @foreach ($officer as $item)
                                <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $item->username}}</td>
                                        <td>
                                                @if ($item->phone)
                                                        {{ $item->phone }}
                                                @else
                                                        -
                                                @endif
                                        </td>
                                        <td>
                                                <a href="/user-detail/{{$item->slug}}" class="btn btn-warning">Detail</a>
                                                <a href="/user-ban/{{$item->slug}}" class="btn btn-danger">Ban</a>
                                        </td>
                                </tr>
                                @endforeach
                        </tbody>
                </table>
        </div>
@endsection
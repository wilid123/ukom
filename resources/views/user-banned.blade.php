@extends('layout.mainlayout')

@section('title', 'Banned Users')

@section('content')
        <h1>Banned Users</h1>

        <div class="mt-5 d-flex justify-content-end">
                <a href="/users" class="btn btn-primary">Back To List Users</a>
        </div>

        <div class="mt-5">
        @if (session('status'))
                <div class="alert alert-success">
                        {{ session('status') }}
                </div>
        @endif
        </div>
        
        <div class="my-5">
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
                                @foreach ($bannedUsers as $item)
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
                                                <a href="/user-restore/{{$item->slug}}" class="btn btn-warning">Restore</a>
                                                <a href="/user-force/{{$item->slug}}" class="btn btn-danger">Delete Permanent</a>
                                        </td>
                                </tr>
                                @endforeach
                        </tbody>
                </table>
        </div>
@endsection
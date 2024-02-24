@extends('layout.mainlayout')

@section('title', 'Add User')

@section('content')
<h1>Add New User</h1>

<div class="mt-5 d-flex justify-content-end">
        <a href="/users" class="btn btn-primary">Back</a>
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
                        @foreach ($registeredUsers as $item )
                        <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $item->username}}</td>
                                <td>
                                        @if ($item->phone)
                                        {{ $item->phone }}
                                        @else
                                        eweuh
                                        @endif
                                </td>
                                <td>
                                        <a href="/user-detail/{{$item->slug}}" class="btn btn-warning">Detail</a>
                                </td>
                        </tr>
                        @endforeach


                </tbody>
        </table>
</div>
@endsection
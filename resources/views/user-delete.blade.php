@extends('layout.mainlayout')

@section('title', 'Delete User')

@section('content')
    <h2>Yakin hapus {{ $user->username }} ?</h2>
    <div class="mt-5">
        <a href="/user-destroy/{{$user->slug}}" class="btn btn-danger">Sure</a>
        <a href="/users" class="btn btn-primary">Gak jadi</a>
    </div>
@endsection
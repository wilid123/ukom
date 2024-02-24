@extends('layout.mainlayout')

@section('title', 'Edit Category')

@section('content')
    <h2>Emang kamu yakin hapus {{ $category->name }} ?</h2>
    <div class="mt-5">
        <a href="/category-destroy/{{$category->slug}}" class="btn btn-danger">Sure</a>
        <a href="/categories" class="btn btn-primary">Gak jadi</a>
    </div>
@endsection
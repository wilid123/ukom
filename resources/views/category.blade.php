@extends('layout.mainlayout')

@section('title', 'Categories')

@section('content')
        <h1>Category List</h1>

        <div class="mt-5 d-flex justify-content-end">
                <a href="category-deleted" class="btn btn-dark me-3">Deleted Data</a>
                <a href="category-add" class="btn btn-primary">Add Data</a>
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

        <div class="my-5 card p-3 border shadow">
                <table class="table">
                        <thead>
                                <tr>
                                        <td>No</td>
                                        <td>Name</td>
                                        <td>Action</td>
                                </tr>
                        </thead>
                        <tbody>
                                @foreach ($categories as $item)
                                <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $item->name}}</td>
                                        <td>
                                                <a href="category-edit/{{ $item->slug}}" class="btn btn-warning">Edit</a>
                                                <a href="category-delete/{{ $item->slug}}" class="btn btn-danger">Delete</a>
                                        </td>
                                </tr>
                                @endforeach
                        </tbody>
                </table>
        </div>
@endsection
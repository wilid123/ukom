@extends('layout.mainlayout')

@section('title', 'Deleted Categories')

@section('content')
        <h1>Deleted Category List</h1>

        <div class="mt-5 d-flex justify-content-end">
                <a href="/categories" class="btn btn-danger">Back</a>
        </div>

        
        <div class="mt-5">
        @if (session('status-warning'))
                <div class="alert alert-warning">
                        {{ session('status-danger') }}
                </div>
        @endif
        </div>
        <div class="my-5">
                <table class="table">
                        <thead>
                                <tr>
                                        <td>No</td>
                                        <td>Name</td>
                                        <td>Action</td>
                                </tr>
                        </thead>
                        <tbody>
                                @foreach ($deletedCategories as $item)
                                <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $item->name}}</td>
                                        <td>
                                                <a href="category-restore/{{$item->slug}}" class="btn btn-warning">Restore</a>
                                                <a href="category-force/{{$item->slug}}" class="btn btn-danger">Delete Permanent</a>
                                        </td>
                                </tr>
                                @endforeach
                        </tbody>
                </table>
        </div>
@endsection
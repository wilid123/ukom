@extends('layout.mainlayout')

@section('title', 'Deleted Books')

@section('content')

<script>
        $(document).ready(function() {
                $('#tables').DataTable({
                        "scrollY": "300px",
                        "scrollCollapse": true,
                        "paging": true
                });
        });
</script>

<h1>Deleted Book List</h1>

<div class="mt-5 d-flex justify-content-end">
        <a href="/books" class="btn btn-danger">Back</a>
</div>

<div class="mt-5">
        @if (session('status'))
        <div class="alert alert-success">
                {{ session('status') }}
        </div>
        @endif
</div>
<div class="my-5">
        <table class="table shadow radius" id="tables">
                <thead>
                        <tr>
                                <td>No</td>
                                <td>Code</td>
                                <td>Title</td>
                                <td>Action</td>
                        </tr>
                </thead>
                <tbody>
                        @foreach ($deletedBooks as $item)
                        <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $item->book_code}}</td>
                                <td>{{ $item->title}}</td>
                                <td>
                                        <a href="/book-restore/{{$item->slug}}" class="btn btn-warning">Restore</a>
                                        <a href="/book-force/{{$item->slug}}" class="btn btn-danger">Delete</a>
                                </td>
                        </tr>
                        @endforeach
                </tbody>
        </table>
</div>
@endsection
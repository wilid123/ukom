@extends('layout.mainlayout')
@section('title', 'Add Books')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<h1>Add New Books</h1>


<div class="mt-5 ">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row col-lg-12 p-3 mx-2 shadow">
        <form action="book-add" method="post" enctype="multipart/form-data" class="col">
            @csrf
            <div class="">
                <label for="code" class="form-label">Code</label>
                <input type="text" name="book_code" id="code" class="form-control" placeholder="Book's Code" value="{{ $nextCode ?? old('book_code') }}" >
            </div>
            <div class="mt-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="" value="{{ old('title') }}">
            </div>
            <div class="mt-3">
                <label for="writer" class="form-label">Writer</label>
                <input type="text" name="writer" id="writer" class="form-control" placeholder="" value="{{ old('writer') }}">
            </div>
            <div class="mt-3">
                <label for="publisher" class="form-label">Publisher</label>
                <input type="text" name="publisher" id="publisher" class="form-control" placeholder="" value="{{ old('publisher') }}">
            </div>
            <div class="mt-3">
                <label for="year_publish" class="form-label">Year Publish</label>
                <input type="text" name="year_publish" id="year_publish" class="form-control" placeholder="" value="{{ old('year_publish') }}">
            </div>
            <div class="mt-3">
                <label for="image" class="form-label">Image Cover</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="mt-3">
                <label for="category" class="form-label">Category</label>
                <select name="categories[]" id="category" class="form-control" require>
                    @foreach ($categories as $item)
                    <option value="{{ $item->id}}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3">
                <button class="btn btn-success w-100" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select-multiple').select2();
    });
</script>
@endsection
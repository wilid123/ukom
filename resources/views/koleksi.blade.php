@extends('layout.mainlayout')

@section('title', 'My Collection')

@section('content')
<h2 class="mb-4">My Collection</h2>

<!-- Form pencarian buku -->
<form action="" method="get">
        <div class="row">
                <div class="col-12 col-sm-6">
                        <select name="category" id="category" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                        </select>
                </div>
                <div class="col-12 col-sm-6">
                        <div class="input-group mb-3">
                                <input type="text" class="form-control" name="title" placeholder="Select Book's Title">
                                <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                </div>
        </div>
</form>

<!-- Daftar buku dalam koleksi -->
<div class="my-3">
        <div class="row">
                @foreach ($collection as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card shadow h-100">
                                <a href="/book-detail/{{ $item->book->slug }}" class="text-decoration-none text-dark">
                                        <img src="{{ $item->book->cover != null ? asset('storage/cover/'.$item->book->cover) : asset('images/NoImage.jpg') }}" class="card-img-top" draggable="false">
                                        <div class="card-body">
                                                <h5 class="card-title">{{ $item->book->book_code }}</h5>
                                                <p class="card-text">{{ $item->book->title }}</p>
                                                <p class="card-text text-end fw-bold {{ $item->book->status == 'in stock' ? 'text-success' : 'text-danger' }}">{{ $item->book->status }}</p>
                                        </div>
                                </a>
                        </div>
                </div>
                @endforeach
        </div>
</div>
@endsection
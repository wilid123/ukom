@extends('layout.mainlayout')

@section('title', 'Buku List')

@section('content')
<h2 class="mb-4">Book List</h2>

<form action="" method="get">
    <div class="row">
        <div class="col-6">
            <select name="category" id="category" class="form-control">
                <option value="">Select Category</option>
                @foreach ($categories as $item)
                <option value="{{ $item->id}}">{{ $item -> name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6">
            <div class="input-group mb-3">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>

<div class="my-3">
    <div class="row">
        @foreach ( $books as $item)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <div class="card shadow h-100" >
                <a href="/book-detail/{{ $item->slug}}" class="text-decoration-none text-dark">
                <img src="{{ $item->cover != null ? asset('storage/cover/'.$item->cover) : asset('images/NoImage.jpg')}}" class="card-img-top" draggable="false">
                    <div class="card-body">
                        <h5 class="card-title " >{{ $item->book_code}}</h5>
                        <p class="card-text" style="text-transform: capitalize;">{{ $item->title}}</p>
                        @foreach ($item->categories as $category)
                        <p class="card-text" style="text-transform: capitalize;">{{ $category->name}}</p>
                        
                        @endforeach
                        <p class="card-text">{{ $item->name}}</p>
                        <p class="card-text text-end fw-bold {{ $item->status == 'in stock' ? 'text-success' : 'text-danger'}} ">
                            {{ $item->status }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
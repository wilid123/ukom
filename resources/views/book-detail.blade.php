@extends('layout.mainlayout')

@section('title', 'Detail Book')

@section('content')
<h1 class="text-center">Detail Book</h1>
@if (session('status'))
<div class="alert alert-warning text-center">
    {{ session('status') }}
</div>
@endif
@if (session('message'))
<div class="alert {{ session('alert-class') }}">
    {{ session('message') }}
</div>
@endif
@if (session('status-danger'))
<div class="alert alert-danger text-center">
    {{ session('status-danger') }}
</div>
@endif


<div class="row shadow rounded g-0 mt-3 border">
    <div class="col-lg-3">
        <div class="">
            <img src="{{ $books->cover != null ? asset('storage/cover/'.$books->cover) : asset('images/NoImage.jpg') }}" class="card-img-top rounded" draggable="false">
        </div>
    </div>
    <div class="col-lg-9 p-3 mt-2">
        <h5 class="card-title">{{ $books->book_code }}</h5>
        <p class="mt-2 fw-bold text-uppercase">{{ $books->title }}</p>
        <div class="d-flex gap-2">
            <p class="fw-bold">Status :</p>
            <p class="fw-bold {{ $books->status == 'in stock' ? 'text-success' : 'text-danger' }}">{{ $books->status }}</p>
        </div>
        <span class="fw-bold">Sinopsis :</span>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut saepe totam omnis, eaque in, accusantium corrupti voluptates suscipit dignissimos quisquam, alias perspiciatis aspernatur delectus vel quos laborum nihil molestias. Aliquam!</p>
        <span class="fw-bold">Rating :</span>
        @php
        $totalRating = 0;
        $totalUsers = 0;
        foreach ($rating as $item) {
        $totalRating += $item->rating;
        $totalUsers++;
        }
        $averageRating = $totalUsers > 0 ? intval($totalRating / $totalUsers) : 0;
        @endphp
        <p>{{ $averageRating }}/10</p>
        @if ($books->status == 'not available')
        <button class="btn btn-success w-100 disabled">Rent</button>
        @else
        <form action="{{ route('book.rent', ['slug' => $books->slug]) }}" method="post">
            @csrf
            <button class="btn btn-success w-100">Rent</button>
        </form>
        @endif

        @if ($private && $private->status == 'Added')
        <a href="{{ route('koleksi-destroy', ['slug' => $books->slug]) }}" class="btn text-light btn-danger w-100 mt-2">Uncollection</a>
        @else
        <a href="{{ route('book.collect', ['slug' => $books->slug]) }}" class="btn text-light btn-warning w-100 mt-2">Add to Collection</a>
        @endif

        @php
        $btncomments = $btncomment->where('book_id', $books->id )->where('user_id', Auth::user()->id)->first();
        @endphp

        @if ($btncomments && $btncomments->status == 'added')
        <a href="" class="text-light btn btn-info w-100 mt-2" data-bs-toggle="modal" data-bs-target="#editRating">Edit Rating</a>
        <a href="" class="text-light btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#deleteRating">Delete Rating</a>
        @else
        <a href="" class="text-light btn btn-info w-100 mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Rating</a>
        @endif
    </div>
</div>





<div class="row shadow rounded g-0 mt-3">
    <div class="col-lg-12 p-3">
        <div>
            <h2>Ulasan</h2>
            @php $count = 0; @endphp
            @foreach ($comment as $item)
            @php $count++; @endphp
            @if ($count <= 2) <div class="mt-3">
                <p class="fw-bold">{{ $item->users->username }}
                    <span class="fw-light ms-2">{{ $item->rating }}/10</span>
                </p>
                <p>{{ $item->review }}</p>
        </div>
        @endif
        @endforeach
        @if ($count > 2)
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            See All Comment
        </button>
        @endif
    </div>
</div>
</div>


<!-- Modal Comment -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">All Comments</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($rating as $item)
                <div class="">
                    <p class="fw-bold">{{ $item->users->username }}
                        <span class="fw-light ms-2">{{ $item->rating }}/10</span>
                    <p>{{ $item->review }}</p>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rating -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('book.rating', ['slug' => $books->slug]) }}" method="POST">
                    @csrf
                    <div class="mt-2">
                        <label for="user" class="form-label">Username</label>
                        <input type="text" name="user" id="user" class="form-control" placeholder="Writer" value="{{ auth()->user()->username }}" disabled>
                    </div>
                    <div class="mt-3">
                        <label for="book_name" class="form-label">Book Name</label>
                        <input type="text" name="book_name" id="book_name" class="form-control" placeholder="Book's Code" value="{{ $books->title }}" disabled>
                    </div>
                    <div class="mt-3">
                        <label for="review" class="form-label">Your Review</label>
                        <textarea type="text" name="review" id="review" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="customRange3" class="form-label">Rating</label>
                        <input type="range" class="form-range" min="1" max="10" step="1" id="customRange3" name="rating" required>
                        <span id="ratingValue" class="text-center w-100">5</span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn text-light btn-primary">Save Rate</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal EDIT Rating -->
<div class="modal fade" id="editRating" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('book.rating.update', ['slug' => $books->slug]) }}" method="POST">
                    @csrf
                    <div class="mt-2">
                        <label for="user" class="form-label">Username</label>
                        <input type="text" name="user" id="userEdit" class="form-control" placeholder="Writer" value="{{ auth()->user()->username }}" disabled>
                    </div>
                    <div class="mt-3">
                        <label for="book_name" class="form-label">Book Name</label>
                        <input type="text" name="book_name" id="book_nameEdit" class="form-control" placeholder="Book's Code" value="{{ $books->title }}" disabled>
                    </div>
                    @foreach($resultComment as $singleComment)
                    <div class="mt-3">
                        <label for="review" class="form-label">Your Review</label>
                        <textarea type="text" name="review" id="reviewEdit" class="form-control" rows="5" required>{{ $singleComment->review }}</textarea>
                    </div>
                    <div class="mt-3">
                        <label for="customRange4" class="form-label">Rating</label>
                        <input type="range" class="form-range" min="1" max="10" step="1" id="customRange4" name="rating" required>
                        <span id="ratingValueEdit" class="text-center w-100">{{ $singleComment->rating }}</span>
                    </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-light btn-primary">Save Rate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Rating -->
<div class="modal fade" id="deleteRating" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rating-destroy', ['slug' => $books->slug]) }}" method="POST">
                    @csrf
                    <div class="mt-2">
                        <p>Yakin menghapus Rating ini ??</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-light btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Live Rating -->
<script>
    var rangeInput = document.getElementById('customRange3');
    var ratingValue = document.getElementById('ratingValue');

    rangeInput.addEventListener('input', function() {
        ratingValue.innerText = this.value;
    });

    var rangeInputEdit = document.getElementById('customRange4');
    var ratingValueEdit = document.getElementById('ratingValueEdit');

    rangeInputEdit.addEventListener('input', function() {
        ratingValueEdit.innerText = this.value;
    });
</script>



@endsection
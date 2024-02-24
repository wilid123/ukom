@extends('layout.mainlayout')

@section('title', 'Books')

@section('content')
<script>
        $(document).ready(function() {
                $('#tables').DataTable({
                        "scrollY": "300px",
                        "scrollCollapse": true,
                        "paging": true,
                        layout: {
                                topStart: {
                                        buttons: [{
                                                        extend: 'copyHtml5',
                                                        exportOptions: {
                                                                columns: [0, ':visible']
                                                        }
                                                },
                                                {
                                                        extend: 'excelHtml5',
                                                        exportOptions: {
                                                                columns: ':visible'
                                                        }
                                                },
                                                {
                                                        extend: 'pdfHtml5',
                                                        exportOptions: {
                                                                columns: [0, 1, 2, 3, 4, 5]
                                                        }
                                                },
                                        ]
                                }
                        }
                });

                $('.add-stock-btn').click(function() {
                        var slug = $(this).data('slug');
                        $('#addStockModal').find('#slug').val(slug);
                });

                $('.reduce-stock-btn').click(function() {
                        var slug = $(this).data('slug');
                        $('#reduceStockModal').find('#slug').val(slug);
                });
        });
</script>

<h1>Books List</h1>

<div class="mt-5 d-flex justify-content-end">
        <a href="book-deleted" class="me-3 btn btn-info">View Book Deleted</a>
        <a href="book-add" class="me-3 btn btn-primary">Add Books</a>

        @foreach ($books as $item)
        <!-- Add Stock Modal -->
        <div class="modal fade" id="addStockModal{{ $item->id }}" tabindex="-1" aria-labelledby="addStockModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title" id="addStockModalLabel{{ $item->id }}">Update Stock</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <form action="{{ route('books.updateStock', ['slug' => $item->slug]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="slug" name="slug" value="{{ $item->slug }}">
                                                <div class="form-group">
                                                        <label for="current_stock" class="form-label">Current Stock</label>
                                                        <input type="text" value="{{ $item->stock }}" id="current_stock" class="form-control" disabled>
                                                </div>
                                                <div class="form-group mt-3">
                                                        <label for="stock">Add Stock</label>
                                                        <input type="number" class="form-control" id="stock" name="stock" min="1">
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Update Stock</button>
                                        </form>
                                </div>
                        </div>
                </div>
        </div>

        <!-- Reduce Stock Modal -->
        <div class="modal fade" id="reduceStockModal{{ $item->id }}" tabindex="-1" aria-labelledby="reduceStockModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title" id="reduceStockModalLabel{{ $item->id }}">Update Stock</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <form action="{{ route('books.updateStock', ['slug' => $item->slug]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="slug" name="slug" value="{{ $item->slug }}">
                                                <div class="form-group">
                                                        <label for="current_stock" class="form-label">Current Stock</label>
                                                        <input type="text" value="{{ $item->stock }}" id="current_stock" class="form-control" disabled>
                                                </div>
                                                <div class="form-group mt-3">
                                                        <label for="reducestock">Reduce Stock</label>
                                                        <input type="number" class="form-control" id="reducestock" name="reducestock" min="1">
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Update Stock</button>
                                        </form>
                                </div>
                        </div>
                </div>
        </div>
        @endforeach
</div>

<div class="mt-3">
        @if (session('status'))
        <div class="alert alert-success">
                {{ session('status') }}
        </div>
        @endif
</div>

<div class="">
        @if (session('status-warning'))
        <div class="alert alert-warning">
                {{ session('status-warning') }}
        </div>
        @endif
</div>

<div class="">
        @if (session('status-danger'))
        <div class="alert alert-danger">
                {{ session('status-danger') }}
        </div>
        @endif
</div>

<div class="card border shadow p-3">
        <table class="table" id="tables">
                <thead>
                        <tr>
                                <td>No</td>
                                <td>Code</td>
                                <td>Title</td>
                                <td>Categories</td>
                                <td>Status</td>
                                <td>Stock</td>
                                <td class="text-center">Action</td>
                        </tr>
                </thead>
                <tbody>
                        @foreach ($books as $item)
                        <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->book_code }}</td>
                                <td style="text-transform: capitalize;">{{ $item->title }}</td>
                                <td style="text-transform: capitalize;">
                                        @foreach ($item->categories as $category)
                                        {{ $category->name }}
                                        @endforeach
                                </td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->stock }}</td>
                                <td class="text-center">
                                        <a href="/book-edit/{{ $item->slug }}" class="btn btn-warning me-2">Edit</a>
                                        <a href="/book-delete/{{ $item->slug }}" class="btn btn-danger">Delete</a>
                                        <button type="button" class="btn btn-info add-stock-btn" data-bs-toggle="modal" data-bs-target="#addStockModal{{ $item->id }}" data-slug="{{ $item->slug }}">
                                                <i class="bi bi-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger reduce-stock-btn" data-bs-toggle="modal" data-bs-target="#reduceStockModal{{ $item->id }}" data-slug="{{ $item->slug }}">
                                                <i class="bi bi-dash"></i>
                                        </button>
                                </td>
                        </tr>
                        @endforeach
                </tbody>
        </table>
</div>
@endsection
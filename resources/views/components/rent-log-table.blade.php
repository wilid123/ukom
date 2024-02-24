<div>
        <div class="mt-4 shadow p-3">
                <p>Sedang Dipinjam</p>
                <table class="card-body table ">
                        <thead>
                                <tr>
                                        <td>No</td>
                                        <td>User</td>
                                        <td>Book</td>
                                        <td>Rent Date</td>
                                        <td>Return Date</td>
                                        <td>Actual Return Date</td>
                                        <td>Status</td>
                                </tr>
                        </thead>
                        <tbody>
                                @foreach ( $rentlog as $item)
                                <tr class="">
                                @if ($item->status == 'In Progress')
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->username }}</td>
                                        <td>{{ $item->book->title }}</td>
                                        <td>{{ $item->rent_date }}</td>
                                        <td>{{ $item->return_date }}</td>
                                        @if ($item->actual_return_date == null)
                                        <td class="fw-bold">-</td>
                                        @else
                                        <th>{{ $item->actual_return_date }}</th>
                                        @endif                  
                                        <td>{{ $item->status }}</td>
                                @endif
                                </tr>
                                @endforeach
                        </tbody>
                </table>
        </div>
        <div class="mt-4 shadow p-3">
                <p>Selesai Dipinjam</p>
                <table class="card-body table ">
                        <thead>
                                <tr>
                                        <td>No</td>
                                        <td>User</td>
                                        <td>Book</td>
                                        <td>Rent Date</td>
                                        <td>Return Date</td>
                                        <td>Actual Return Date</td>
                                        @if (Auth::user()->role_id == 1)
                                        <td>Action</td>
                                        @else
                                        <td>Status</td> 
                                        @endif
                                </tr>
                        </thead>
                        <tbody>
                                @foreach ( $rentlog as $item)
                                <tr class="{{ $item->actual_return_date == null ? '' : ($item->return_date < $item->actual_return_date ? 'text-danger' : 'text-success') }}">
                                @if ($item->status == 'Tuntas' || $item->status == 'Denda')
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->username }}</td>
                                        <td>{{ $item->book->title }}</td>
                                        <td>{{ $item->rent_date }}</td>
                                        <td>{{ $item->return_date }}</td>
                                        <th>{{ $item->actual_return_date }}</th>
                                        @if (Auth::user()->role_id == 1)
                                        <th></th>
                                        @else
                                        @if ($item->status == 'Tuntas')
                                        <td class="fw-bold text-success">{{ $item->status }}</td>
                                        @else
                                        <td class="fw-bold text-danger">{{ $item->status }}</td>
                                        @endif
                                        @endif
                                </tr>
                                @endif
                                @endforeach
                        </tbody>
                </table>
        </div>
        <!-- People find pleasure in different ways. I find it in keeping my mind clear. - Marcus Aurelius -->
</div>
@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
        
        <h1>Welcome, {{Auth::user()->username}}</h1>

        <div class="row mt-5">
                <div class="col-lg-6">
                        <div class="card-data book shadow">
                                <a href="/books">
                                <div class="row">
                                        <div class="col-6"><i class="bi bi-journal-bookmark"></i></div>
                                        <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                                                <div class="card-desk">Book</div>
                                                <div class="card-count">{{ $book_count }}</div>
                                        </div>
                                </div>
                                </a>
                        </div>
                </div>
                <div class="col-lg-6">
                        <div class="card-data category shadow">
                                <a href="/categories">
                                <div class="row">
                                        <div class="col-6"><i class="bi bi-list"></i></div>
                                        <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                                                <div class="card-desk">Category</div>
                                                <div class="card-count">{{ $category_count }}</div>
                                        </div>
                                </div>
                                </a>
                        </div>
                </div>
                <div class="col-lg-6 mt-3">
                        <div class="card-data user shadow">
                                <a href="/users">
                                <div class="row">
                                        <div class="col-6"><i class="bi bi-people"></i></div>
                                        <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                                                <div class="card-desk">User</div>
                                                <div class="card-count">{{ $user_count }}</div>
                                        </div>
                                </div>
                                </a>
                        </div>
                </div>
                <div class="col-lg-6 mt-3">
                        <div class="card-data user shadow">
                                <a href="/users">
                                <div class="row">
                                        <div class="col-6"><i class="bi bi-people"></i></div>
                                        <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                                                <div class="card-desk">Officier</div>
                                                <div class="card-count">{{ $petugas_count }}</div>
                                        </div>
                                </div>
                                </a>
                        </div>
                </div>
                <div class="col-lg-12 mt-3">
                        <div class="card-data user shadow">
                                <a href="/users">
                                <div class="row">
                                        <div class="col-6"><i class="bi bi-people"></i></div>
                                        <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                                                <div class="card-desk">Officier</div>
                                                <div class="card-count">{{ $petugas_count }}</div>
                                        </div>
                                </div>
                                </a>
                        </div>
                </div>
        </div>
        <h2 class="my-3">Recent Report</h2>
        <x-rent-log-table :rentlog='$rent_logs' />
@endsection
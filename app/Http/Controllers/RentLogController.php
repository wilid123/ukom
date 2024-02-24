<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\RentLogs;
use Illuminate\Http\Request;

class RentLogController extends Controller
{
    public function index()
    {
        $rentlogs = RentLogs::with(['user', 'book'])->get();
        return view('rentlog', ['rent_logs' => $rentlogs]);
    }

    
}

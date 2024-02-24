<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $name = User::all();
        $bookCount = Book::count();
        $categoryCount = Category::count();
        $userCount = User::where('role_id', 2)->count();
        $petugasCount = User::where('role_id', 3)->count();
        $rentlogs = RentLogs::with(['user', 'book'])->get();
        return view('dashboard', ['book_count' => $bookCount, 'category_count' => $categoryCount, 'user_count' => $userCount,'petugas_count' => $petugasCount,'rent_logs' => $rentlogs, 'name' => $name]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\User;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BookRentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $users = User::where('role_id', '=', 2)->get();
        } else {
            $users = User::where('role_id', '=', 2)->where('id', Auth::user()->id)->get();
        }
        $books = Book::where('status', '=', 'in stock')->get();
        return view('book-rent', ['users' => $users, 'books' => $books]);
    }


    public function store(Request $request)
    {
        $request['rent_date'] = Carbon::now()->toDateString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateString();
        $request['status'] = 'In Progress';

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            Session::flash('message', 'Cannot rent. The Book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        }

        $count = RentLogs::where('user_id', $request->user_id)->where('actual_return_date', null)->count();
        if ($count >= 3) {
            Session::flash('message', 'Cannot rent. user has reached limit of books');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        }

        try {
            DB::beginTransaction();

            RentLogs::create($request->all());

            // Kurangi stok buku
            $book->stock -= 1;
            if ($book->stock <= 0) {
                $book->status = 'not available';
            }
            $book->save();

            DB::commit();

            Session::flash('message', 'Rent book Success');
            Session::flash('alert-class', 'alert-success');
            return redirect('book-rent');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }


    public function returnBook()
    {
        // Ambil user yang memiliki role_id = 2 dan id sesuai dengan user yang sedang login
        $users = User::where('role_id', '=', 2)->where('id', Auth::user()->id)->get();

        // Ambil rent logs berdasarkan user_id
        $rentLogs = RentLogs::where('user_id', Auth::user()->id)->get();

        // Ambil ID buku dari rent logs
        $bookIds = $rentLogs->pluck('book_id')->toArray();

        // Ambil buku yang buku ID-nya terdapapt dalam rent logs
        $books = Book::whereIn('id', $bookIds)->get();

        return view('return-book', ['users' => $users, 'books' => $books, 'rentlog' => $rentLogs]);
    }

    public function saveReturnBook(Request $request)
{
    $rent = RentLogs::where('user_id', $request->user_id)
                    ->where('book_id', $request->book_id)
                    ->whereNull('actual_return_date')
                    ->first();

    if (!$rent) {
        Session::flash('message', 'Rent log not found');
        Session::flash('alert-class', 'alert-danger');
        return redirect('book-return');
    }

    $returnDate = Carbon::parse($rent->return_date);
    $actualReturnDate = Carbon::parse($request->actual_return_date);

    if ($actualReturnDate->greaterThanOrEqualTo($returnDate)) {
        $rent->actual_return_date = $actualReturnDate;
        $rent->status = 'Denda'; // Mengubah status menjadi "Denda" jika kembali terlambat
    } else {
        $rent->actual_return_date = $actualReturnDate;
        $rent->status = 'Tuntas'; // Mengubah status menjadi "Tuntas" jika kembali tepat waktu
    }

    $rent->save();

    // Mengubah status buku menjadi "In Stock" setelah dikembalikan
    $book = Book::find($request->book_id);
    $book->status = 'in stock';
    $book->stock += 1; // Menambahkan stok buku
    $book->save();

    Session::flash('message', 'Return book Success');
    Session::flash('alert-class', 'alert-success');
    return redirect('book-return');
}

}

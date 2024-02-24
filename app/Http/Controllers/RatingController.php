<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\RentLogs;
use Illuminate\Http\Request;
use App\Models\PrivateCollection;
use App\Models\ReviewBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RatingController extends Controller
{
    public function indexCollection(Request $request)
    {
        $categories = Category::all();

        if ($request->category || $request->title) {
            $books = Book::where('title', 'like', '%' . $request->title . '%')
                ->whereHas('categories', function ($q) use ($request) {
                    $q->where('categories.id', $request->category);
                })->get();
        } else {
            $books = Book::all();
        }

        $collection = PrivateCollection::with(['user', 'book'])->where('user_id', Auth::user()->id)->get();

        return view('koleksi', ['books' => $books, 'categories' => $categories, 'collection' => $collection]);
    }

    public function detail($slug)
    {
        $rating = ReviewBook::all();
        $users = User::where('role_id', '=', 2)->where('id', Auth::user()->id)->get();
        $books = Book::where('slug', $slug)->first();
        $categories = Category::all();

        $comment = ReviewBook::with(['users', 'book'])->where('book_id', $books->id)->get();

        $resultComment = ReviewBook::with(['users', 'book'])->where('book_id', $books->id)->where('user_id', Auth::user()->id)->get();

        $btncomment = ReviewBook::with(['users', 'book'])->where('book_id', $books->id)->get();

        $private = PrivateCollection::where('book_id', $books->id)
            ->where('user_id', Auth::id())
            ->first();
        return view('book-detail', ['books' => $books, 'users' => $users, 'private' => $private, 'rating' => $rating, 'comment' => $comment, 'btncomment' => $btncomment, 'resultComment' => $resultComment]);
    }

    public function destroy(Request $request, $slug)
    {
        // Temukan buku yang sesuai berdasarkan slug
        $book = Book::where('slug', $slug)->first();

        // Periksa apakah buku ditemukan sebelum mencoba menghapusnya dari koleksi
        if ($book) {
            // Temukan entri PrivateCollection yang sesuai
            $collection = PrivateCollection::where('book_id', $book->id)
                ->where('user_id', Auth::user()->id)
                ->first();
            // Periksa apakah entri ditemukan sebelum dihapus
            if ($collection) {
                $collection->delete();
                return redirect()->route('book.detail', ['slug' => $slug])->with('status-danger', 'Book deleted from your collection.');
            } else {
                // Jika tidak ada entri yang ditemukan, mungkin ada kesalahan atau entri sudah dihapus sebelumnya
                return redirect()->route('book.detail', ['slug' => $slug])->with('status-danger', 'Book not found in your collection.');
            }
        } else {
            // Jika buku tidak ditemukan, mungkin ada kesalahan atau buku telah dihapus sebelumnya
            return redirect()->route('book.detail', ['slug' => $slug])->with('status', 'Book not found.');
        }
    }

    public function destroyRate(Request $request, $slug)
    {
        // Temukan buku yang sesuai berdasarkan slug
        $book = Book::where('slug', $slug)->first();

        // Periksa apakah buku ditemukan sebelum mencoba menghapusnya dari koleksi
        if ($book) {
            // Temukan entri PrivateCollection yang sesuai
            $collection = ReviewBook::where('book_id', $book->id)
                ->where('user_id', Auth::user()->id)
                ->first();
            // Periksa apakah entri ditemukan sebelum dihapus
            if ($collection) {
                $collection->delete();
                return redirect()->route('book.detail', ['slug' => $slug])->with('status-danger', 'Rate Deleted.');
            } else {
                // Jika tidak ada entri yang ditemukan, mungkin ada kesalahan atau entri sudah dihapus sebelumnya
                return redirect()->route('book.detail', ['slug' => $slug])->with('status-danger', 'Book not found in your collection.');
            }
        } else {
            // Jika buku tidak ditemukan, mungkin ada kesalahan atau buku telah dihapus sebelumnya
            return redirect()->route('book.detail', ['slug' => $slug])->with('status', 'Book not found.');
        }
    }


    public function updateRate(Request $request, $slug)
    {
        // Temukan buku yang sesuai berdasarkan slug
        $book = Book::where('slug', $slug)->first();

        if ($book) {
            // Temukan review berdasarkan user_id dan book_id
            $review = ReviewBook::where('user_id', Auth::id())->where('book_id', $book->id)->first();

            // Pastikan review ditemukan sebelum melanjutkan
            if ($review) {
                // Validasi data yang diterima dari form
                $validatedData = $request->validate([
                    'review' => 'required',
                    'rating' => 'required|numeric|min:1|max:10',
                ]);

                // Set nilai review dan rating baru
                $review->review = $validatedData['review'];
                $review->rating = $validatedData['rating'];

                // Simpan perubahan
                $review->save();

                // Redirect pengguna ke halaman detail buku dengan pesan sukses
                return redirect()->route('book.detail', ['slug' => $book->slug])->with('status', 'Review Updated Successfully!');
            } else {
                // Handle jika review tidak ditemukan
                return redirect()->route('book.detail', ['slug' => $book->slug])->with('error', 'Review not found!');
            }
        } else {
            // Handle jika buku tidak ditemukan
            return redirect()->route('book.detail', ['slug' => $slug])->with('error', 'Book not found!');
        }
    }



    public function collect($slug)
    {
        // Temukan buku berdasarkan slug
        $book = Book::where('slug', $slug)->first();

        // Buat entri baru di tabel private_collection
        PrivateCollection::create([
            'user_id' => auth()->id(), // Menggunakan ID pengguna yang saat ini masuk
            'book_id' => $book->id, // ID buku yang ingin ditambahkan ke koleksi
            'status' => 'Added', // ID buku yang ingin ditambahkan ke koleksi
        ]);


        // Redirect pengguna ke halaman buku dengan pesan sukses
        return redirect()->route('book.detail', ['slug' => $slug])->with('status', 'Book added to your collection.');
    }

    public function rent(Request $request, $slug)
    {
        $user = Auth::user();
        $book = Book::where('slug', $slug)->first();

        $request->validate([
            // Sesuaikan dengan aturan validasi yang diperlukan
        ]);

        if (!$book) {
            // Handle jika buku tidak ditemukan
            return redirect()->back()->with('error', 'Book not found.');
        }

        if ($book->stock <= 0) {
            Session::flash('message', 'Cannot rent. The Book is not available');
            Session::flash('alert-class', 'alert-danger');
            return redirect('book-rent');
        }

        $count = RentLogs::where('user_id', $user->id)->where('actual_return_date', null)->count();
        if ($count >= 3) {
            Session::flash('message', 'Cannot rent. user has reached limit of books');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('book.detail', ['slug' => $slug]);
        }

        try {
            DB::beginTransaction();

            // Simpan data penyewaan ke dalam tabel rent_logs
            RentLogs::create([
                'user_id' => $user->id,
                'book_id' => $book->id, // Menggunakan ID buku
                'rent_date' => Carbon::now()->toDateString(),
                'return_date' => Carbon::now()->addDay(3)->toDateString(),
                'status' => 'In Progress',
            ]);

            // Kurangi stok buku
            $book->stock--;
            if ($book->stock <= 0) {
                $book->status = 'not available';
            }
            $book->save();

            DB::commit();

            Session::flash('message', 'Rent book Success');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('book.detail', ['slug' => $slug]);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }
}

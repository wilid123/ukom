<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReviewBook;
use App\Http\Requests\StoreReviewBookRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\UpdateReviewBookRequest;

class ReviewBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        // Temukan buku berdasarkan slug
        $book = Book::where('slug', $slug)->first();

        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'review' => 'required',
            'rating' => 'required|numeric|min:1|max:10', // Angka rating harus antara 1 dan 10
        ]);

        // Validasi rating agar berada dalam rentang yang benar
        if ($request->rating < 1 || $request->rating > 10) {
            return redirect()->back()->withErrors(['rating' => 'The rating must be between 1 and 10.'])->withInput();
        }

        // Buat entri baru di tabel review_book
        $review = new ReviewBook();
        $review->user_id = auth()->id(); // Gunakan ID pengguna yang saat ini masuk
        $review->book_id = $book->id; // ID buku yang sedang diulas
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->status = 'added';
        $review->save();

        // Redirect pengguna ke halaman detail buku dengan pesan sukses
        return redirect()->route('book.detail', ['slug' => $slug])->with('status', 'Rated Successfully!');
    }


    //     public function store(Request $request, $slug)
    // {
    //     dd($request->all());
    //     // Sisipkan kode Anda di sini
    // }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReviewBook  $reviewBook
     * @return \Illuminate\Http\Response
     */
    public function show(ReviewBook $reviewBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReviewBook  $reviewBook
     * @return \Illuminate\Http\Response
     */
    public function edit(ReviewBook $reviewBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\ReviewBook  
     */
    public function update(Request $request, $slug, $id)
    {
        $book = Book::where('slug', $slug)->first();
        // Temukan review berdasarkan ID

        if ($book) {
            $review = ReviewBook::findOrFail($id);

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
            return redirect()->route('book.detail', ['slug' => $review->book->slug])->with('status', 'Review Updated Successfully!');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReviewBook  $reviewBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReviewBook $reviewBook)
    {
        //
    }
}

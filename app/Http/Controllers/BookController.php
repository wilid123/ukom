<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Database\Seeders\BookSeeder;
use App\Models\PrivateCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('book', ['books' => $books]);
    }

    public function add()
    {
        $categories = Category::all();

        // Mendapatkan kode buku terbaru dari database
        $latestBook = Book::latest()->first();

        // Jika tidak ada buku sebelumnya, kita mulai dengan kode A01-001
        if (!$latestBook) {
            $nextCode = 'A01-001';
        } else {
            // Membagi kode buku terbaru menjadi dua bagian: huruf (A01) dan angka (001)
            $parts = explode('-', $latestBook->book_code);
            $prefix = $parts[0];
            $number = intval($parts[1]);

            // Menaikkan nomor buku
            $number++;

            // Mengonversi nomor buku ke format tiga digit dengan padding nol
            $paddedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);

            // Menggabungkan kembali huruf dan nomor buku untuk membuat kode buku baru
            $nextCode = $prefix . '-' . $paddedNumber;
        }

        return view('book-add', ['categories' => $categories, 'nextCode' => $nextCode]);
    }


    public function store(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            'book_code' => 'required|unique:books,book_code|max:255',
            'title' => 'required|max:255',
            'writer' => 'required|max:255',
            'publisher' => 'required|max:255',
            'year_publish' => 'required|max:255'
        ]);
    
        // Mengatur stock menjadi 0
        
        $request['stock'] = '1';
    
        // Mengunggah gambar jika ada
        $newName = '';
        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->title . '-' . now()->timestamp . '.' . $extension;
            $request->file('image')->storeAs('cover', $newName);
        }
    
        // Menambahkan nama file gambar ke dalam data request
        $request['cover'] = $newName;
    
        // Membuat entri buku baru
        $book = Book::create($request->all());
    
        // Menyinkronkan kategori hanya jika tidak kosong
        if ($request->filled('categories')) {
            $book->categories()->sync($request->categories);
        }
    
        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect('books')->with('status', 'Book Added Successfully');
    }
    


    public function edit($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $categories = Category::all();
        return view('book-edit', ['categories' => $categories, 'book' => $book]);
    }

    public function update(Request $request, $slug)
    {
        // Ambil data buku dari slug
        $book = Book::where('slug', $slug)->first();

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            Storage::delete('cover/' . $book->cover);

            // Simpan file gambar baru
            $newImage = $request->file('image')->store('cover');

            // Set nama gambar baru ke dalam data request
            $request->merge(['cover' => $newImage]);
        }

        // Perbarui buku dengan data yang diterima
        $book->update($request->all());

        // Sinkronkan kategori jika ada
        if ($request->categories) {
            $book->categories()->sync($request->categories);
        }

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect('books')->with('status-warning', 'Book Updated Successfully');
    }


    public function delete($slug)
    {
        $book = Book::where('slug', $slug)->first();
        return view('book-delete', ['book' => $book]);
    }

    public function destroy($slug)
    {
        $book = Book::where('slug', $slug)->first();
        $book->delete();
        return redirect('books')->with('status-danger', 'Book Deleted Successfully');
    }

    public function deletedBook()
    {
        $deletedBooks = Book::onlyTrashed()->get();
        return view('book-deleted-list', ['deletedBooks' => $deletedBooks]);
    }

    public function restore($slug)
    {
        $book = Book::withTrashed()->where('slug', $slug)->first();
        $book->restore();
        return redirect('books')->with('status-warning', 'Book Restored Successfully');
    }

    public function force($slug)
    {
        $book = Book::withTrashed()->where('slug', $slug)->first();
        if ($book) {
            // Temukan dan hapus semua entri BookCategory yang terkait
            BookCategory::where('book_id', $book->id)->delete();

            // Hapus buku
            $book->forceDelete();

            return redirect('books')->with('status', 'Book Deleted Permanent Successfully');
        } else {
            // Jika buku tidak ditemukan, mungkin ada kesalahan atau buku telah dihapus sebelumnya
            return redirect('books')->with('status', 'Book not found.');
        }
    }

    public function stock($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        return view('stock-book', compact('book'));
    }

    public function updateStock(Request $request, $slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // Validasi input untuk memastikan hanya angka yang diterima dan minimal 1
        $request->validate([
            'stock' => 'nullable|integer|min:1', // stock dapat kosong
            'reducestock' => 'nullable|integer|min:1', // Validasi untuk pengurangan stok
        ]);

        // Jika input 'stock' diisi, itu berarti pengguna ingin menambah stok
        if ($request->has('stock')) {
            $stockToAdd = $request->stock;
            $book->stock += $stockToAdd; // Menambahkan stok yang dimasukkan ke stok buku yang ada
        }

        // Jika input 'reducestock' diisi, itu berarti pengguna ingin mengurangi stok
        if ($request->has('reducestock')) {
            $stockToReduce = $request->reducestock;
            // Pastikan stok yang ingin dikurangi tidak melebihi stok yang ada
            if ($stockToReduce <= $book->stock) {
                $book->stock -= $stockToReduce; // Mengurangi stok buku
            } else {
                return redirect('books')->with('status-danger', 'Cannot reduce stock more than available');
            }
        }

        // Update status buku sesuai dengan persediaan yang tersedia
        if ($book->stock == 0) {
            $book->status = 'not available';
        } else {
            $book->status = 'in stock';
        }

        $book->save();

        return redirect('books')->with('success', 'Stock updated successfully');
    }
}

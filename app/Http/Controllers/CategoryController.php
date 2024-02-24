<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category', ['categories' => $categories]);
    }

    public function add()
    {
        return view('category-add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ]);

        $category = Category::create($request->all());
        return redirect('categories')->with('status', 'Category Added Successfully');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('category-edit', ['category' => $category]);
    }

    public function update(Request $request,$slug)
    {
        $validate = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ]);

        $category = Category::where('slug', $slug)->first();
        $category->slug = null;
        $category->update($request->all());
        return redirect('categories')->with('status-warning', 'Category Updated Successfully');
    }

    public function delete($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('category-delete', ['category' => $category]);
        // $category = Category::where('slug', $slug)->first();
        // $category->delete();
        // return redirect('categories')->with('status', 'Category Deleted Successfully');
    }
    
    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $category->delete();
        return redirect('categories')->with('status', 'Category Deleted Successfully');
    }

    public function deletedCategory()
    {
        $deletedCategories = Category::onlyTrashed()->get();
        return view ('category-deleted-list', ['deletedCategories' => $deletedCategories]);
    }
    
    public function restore($slug)
    {
        $category = Category::withTrashed()->where('slug', $slug)->first();
        $category->restore();
        return redirect ('categories')->with('status', 'Category Restored Successfully');
    }

    // Fungsi untuk menghapus kategori berdasarkan slug
    public function force($slug)
    {
        $category = Category::withTrashed()->where('slug', $slug)->first();
        if ($category) {
            // Temukan entri PrivateCollection yang sesuai
            $collection = BookCategory::where('category_id', $category->id)
                ->where('book_id', Auth::book()->id)
                ->first();
            // Periksa apakah entri ditemukan sebelum dihapus
            if ($collection) {
                $collection->delete();
                $category->forceDelete();
                return redirect('categories')->with('status', 'Book Deleted Permanent Successfully');
            } else {
                // Jika tidak ada entri yang ditemukan, mungkin ada kesalahan atau entri sudah dihapus sebelumnya
                return redirect('categories')->with('status-danger', 'Book not found in your collection.');
            }
        } else {
            // Jika buku tidak ditemukan, mungkin ada kesalahan atau buku telah dihapus sebelumnya
            return redirect('categories')->with('status', 'Book not found.');
        }
        $category->forceDelete();
        return redirect ('categories')->with('status-danger', 'Category Deleted Permanent');
    }
    
    

}

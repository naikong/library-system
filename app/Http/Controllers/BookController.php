<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Book;
use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 rows per page

        $query = Book::query();

        if ($search) {
            $query->where('book_name', 'LIKE', "%{$search}%")
                ->orWhere('book_author', 'LIKE', "%{$search}%")
                ->orWhere('book_isbn', 'LIKE', "%{$search}%")
                ->orWhere('book_number', 'LIKE', "%{$search}%")
                ->orWhereHas('subject', function ($q) use ($search) {
                    $q->where('subject_name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('category_name', 'LIKE', "%{$search}%");
                });
        }

        $books = $query->paginate($perPage);

        return view('chakriya.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $categories = Category::all();

        return view('chakriya.book.create', compact('subjects', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_name' => 'required|string|max:255',
            'book_number' => 'required|numeric|min:1',
            'book_isbn' => 'required|string|max:255',
            'book_author' => 'required|string|max:255',
            'subject_id' => 'required|exists:subject,id',
            'category_id' => 'required|exists:category,id',
            'book_quantity' => 'nullable|integer|min:0',
            'book_price' => 'required|numeric|min:0',
            'book_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('book.create')
                ->withInput()
                ->withErrors($validator);
        }

        $product = new Book();
        $product->book_name = $request->book_name;
        $product->book_number = $request->book_number;
        $product->book_isbn = $request->book_isbn;
        $product->book_author = $request->book_author;
        $product->subject_id = $request->subject_id;
        $product->category_id = $request->category_id;
        $product->book_quantity = $request->book_quantity;
        $product->book_price = $request->book_price;

        if ($request->hasFile('book_photo')) {
            $image = $request->file('book_photo');
            $upload = 'img/';
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path($upload), $filename);
            $product->book_photo = $upload . $filename;
        }

        $product->save();

        Session::flash('book_create', 'Book created successfully.');
        return redirect()->route('book.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $books = Book::find($id);
        return view('chakriya.book.show')->with('book', $books);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $subjects = Subject::all();
        $categories = Category::all();

        return view('chakriya.book.edit', compact('book', 'subjects', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'book_name' => 'required|string|max:255',
            'book_isbn' => 'required|string|max:255',
            'subject_id' => 'required|exists:subject,id',
            'category_id' => 'required|exists:category,id',
            'book_price' => 'required|numeric|min:0',
            'book_number' => 'required|numeric|min:1',
            'book_author' => 'required|string|max:255',
            'book_quantity' => 'required|numeric|min:0',
            'book_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('book.edit', ['bookId' => $id])
                ->withInput()
                ->withErrors($validator);
        }

        $book = Book::find($id);
        $book->book_name = $request->input('book_name');
        $book->book_isbn = $request->input('book_isbn');
        $book->subject_id = $request->input('subject_id');
        $book->category_id = $request->input('category_id');
        $book->book_price = $request->input('book_price');
        $book->book_number = $request->input('book_number');
        $book->book_author = $request->input('book_author');
        $book->book_quantity = $request->input('book_quantity');

        if ($request->hasFile('book_photo')) {
            $image = $request->file('book_photo');
            $upload = 'img/';
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path($upload), $filename);
            $book->book_photo = $upload . $filename;
        }

        $book->save();

        Session::flash('book_update', 'Book updated successfully.');
        return redirect()->route('book.edit', ['bookId' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        $book->delete();
        Session::flash('book_delete', 'book is deleted.');
        return redirect('book');
    }

    public function export()
    {
        $books = Book::all();
        $filename = "books.csv";
        $handle = fopen($filename, 'w+');

        // Add BOM to fix UTF-8 in Excel
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($handle, ['ID សៀវភៅ', 'ចំណងជើង', 'លេខ ISBN', 'អ្នកនិពន្ធ', 'មុខវិជ្ជា', 'ប្រភេទសៀវភៅ', 'ចំនួន', 'តម្លៃ', 'កាលបរិច្ឆេទបង្កើត']);

        foreach ($books as $book) {
            fputcsv($handle, [
                $book->id,
                $book->book_name,
                $book->book_isbn,
                $book->book_author,
                optional($book->subject)->subject_name ?? 'N/A',
                optional($book->category)->category_name ?? 'N/A',
                $book->book_quantity,
                $book->book_price,
                $book->created_at ? $book->created_at->format('Y-m-d') : '',
            ]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }
}

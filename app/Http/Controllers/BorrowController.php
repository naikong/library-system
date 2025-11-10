<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $perPage = $request->input('per_page', 10);
    $search = $request->input('search');

    $query = Borrow::with(['student', 'book']);

    if ($search) {
        $query->whereHas('student', function ($q) use ($search) {
            $q->where('stu_id', 'LIKE', '%' . $search . '%')
              ->orWhere('name', 'LIKE', '%' . $search . '%');
        });
    }

    $borrowings = $query->paginate($perPage);



    return view('nha.borrowing.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $books = Book::all(); // Fetch all books
        return view('nha.borrowing.create', compact('students', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date',
            'deadline_date' => 'required|date',
            'qty' => 'required|integer|min:1',
            'stu_id' => 'required|exists:student,id',
            'book_id' => 'required|exists:book,id',
            'status' => 'string'
        ]);
    
        $book = Book::find($validatedData['book_id']);
        if ($book->book_quantity < $validatedData['qty']) {
            return redirect()->back()->withErrors(['book_id' => 'ចំនួនសៀវភៅនៅក្នុងបណ្ណាល័យមិនគ្រប់គ្រាន់']);
        }

        // Calculate the price penalty
        $returnDate = \Carbon\Carbon::parse($request->input('return_date'));
        $deadlineDate = \Carbon\Carbon::parse($request->input('deadline_date'));
        $daysLate = $returnDate->gt($deadlineDate) ? $returnDate->diffInDays($deadlineDate) : 0;
        $price_penalty = $daysLate * (-500);
    
        // Add the price penalty to the validated data
        $validatedData['price_penalty'] = $price_penalty;
        $validatedData['status'] = 'កំពុងខ្ចី';
    
        // Create the borrowing record
        Borrow::create($validatedData);
    
        Session::flash('borrowing_create', 'Borrowing detail is created.');
        return redirect()->route('borrow.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrowing = Borrow::with(['student', 'book'])->findOrFail($id);

    $returnDate = \Carbon\Carbon::parse($borrowing->return_date);
    $deadlineDate = \Carbon\Carbon::parse($borrowing->deadline_date);
    $daysLate = $returnDate->gt($deadlineDate) ? $returnDate->diffInDays($deadlineDate) : 0;
    $borrowing->price_penalty = $daysLate * (-500);

    return view('nha.borrowing.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $borrowing = Borrow::findOrFail($id);
        $students = Student::all();
        $books = Book::all();
    
        $returnDate = \Carbon\Carbon::parse($borrowing->return_date);
        $deadlineDate = \Carbon\Carbon::parse($borrowing->deadline_date);
        $daysLate = $returnDate->gt($deadlineDate) ? $returnDate->diffInDays($deadlineDate) : 0;
        $borrowing->price_penalty = $daysLate * (-500);
    
        return view('nha.borrowing.edit', compact('borrowing', 'students', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date',
            'deadline_date' => 'required|date',
            'qty' => 'required|integer|min:1',            
            'stu_id' => 'required|exists:student,id',
            'book_id' => 'required|exists:book,id',
            'status' => 'required|string'
        ]);
    
        // Calculate the price penalty
        $returnDate = \Carbon\Carbon::parse($request->input('return_date'));
        $deadlineDate = \Carbon\Carbon::parse($request->input('deadline_date'));
        $daysLate = $returnDate->gt($deadlineDate) ? $returnDate->diffInDays($deadlineDate) : 0;
        $price_penalty = $daysLate * (-500);
        $book = Book::find($validatedData['book_id']);
        if ($book->book_quantity < $validatedData['qty']) {
            return redirect()->back()->withErrors(['book_id' => 'ចំនួនសៀវភៅនៅក្នុងបណ្ណាល័យមិនគ្រប់គ្រាន់']);
        }
        // Add the price penalty to the validated data
        $validatedData['price_penalty'] = $price_penalty;
    
        // Debugging: Check the validated data
        // dd($validatedData);
    
        // Find the borrowing record and update it
        $borrowing = Borrow::findOrFail($id);
        $borrowing->update($validatedData);
    
        Session::flash('borrowing_update', 'Borrowing detail is updated.');
        return redirect()->route('borrow.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrowing = Borrow::findOrFail($id);
        $borrowing->delete();
        Session::flash('borrowing_delete', 'Borrowing is deleted.');
        return redirect()->route('borrow.index');
    }

    public function export()
    {
        $borrowings = Borrow::with('student', 'book')->get();
        $filename = "borrowings.csv";
        $handle = fopen($filename, 'w+');

        // Add BOM to fix UTF-8 in Excel
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Add the CSV headers
        fputcsv($handle, [
            'ID សិស្ស', 
            'ឈ្មោះសិស្ស', 
            'ID សៀវភៅ', 
            'ឈ្មោះសៀវភៅ', 
            'កាលបរិច្ឆេទខ្ចី', 
            'កាលបរិច្ឆេទត្រូវត្រឡប់', 
            'កាលបរិច្ឆេទសង', 
            'ស្ថានភាព', 
            'ពិន័យ'
        ]);

        // Add the data rows
        foreach ($borrowings as $borrowing) {
            fputcsv($handle, [
                $borrowing->student->stu_id,
                $borrowing->student->name,
                $borrowing->book->id,
                $borrowing->book->book_name,
                \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y'),
                \Carbon\Carbon::parse($borrowing->deadline_date)->format('d/m/Y'),
                \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y'),
                $borrowing->status,
                number_format($borrowing->price_penalty) . '៛'
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

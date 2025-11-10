<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Year;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorPNG;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 rows per page
        $search = $request->input('search'); // Get search term

        $query = Student::query();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->orWhere('stu_id', 'LIKE', '%' . $search . '%')
                ->orWhereHas('faculty', function ($q) use ($search) {
                    $q->where('fac_name', 'LIKE', '%' . $search . '%');
                });
        }

        $students = $query->paginate($perPage);

        return view('eichanudom.students.index', compact('students'));
        // $students = Student::all();
        // return view('eichanudom.students.index')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $years = Year::all();
        $faculty = Faculty::all();

        return view('eichanudom.students.create', compact('years', 'faculty'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'stu_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'year_id' => 'required|exists:year,id',
            'fac_id' => 'required|exists:faculty,id',
            'borrow_qty' => 'nullable|integer|default:0',            
        ]);
        $userId = session('user_id');
        $validatedData['user_id'] = $userId;
        
        Student::create($validatedData);

        Session::flash('student_create', 'Student is created.');
        return redirect()->route('student.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        return view('eichanudom.students.show')->with('student', $student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        $years = Year::all();
        $faculty = Faculty::all();

        return view('eichanudom.students.edit', compact('student', 'years', 'faculty'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'stu_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'year_id' => 'required|exists:year,id',
            'fac_id' => 'required|exists:faculty,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('student.edit', ['studentId' => $id])
                ->withInput()
                ->withErrors($validator);
        }

        $student = Student::find($id);
        $student->stu_id = $request->input('stu_id');
        $student->name = $request->input('name');
        $student->phone = $request->input('phone');
        $student->year_id = $request->input('year_id');
        $student->fac_id = $request->input('fac_id');
        $student->save();

        Session::flash('student_update', 'Student is updated.');
        return redirect()->route('student.edit', ['studentId' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        $student->delete();
        Session::flash('student_delete', 'student is deleted.');
        return redirect('student');
    }

    public function export()
    {
        $students = Student::all();
        $filename = "students.csv";
        $handle = fopen($filename, 'w+');

        // Add BOM to fix UTF-8 in Excel
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($handle, ['ID សិស្ស', 'ឈ្មោះ', 'លេខទូរស័ព្ទ', 'ជំនាញ', 'ឆ្នាំ', 'ចំនួនខ្ចីសៀវភៅ']);

        foreach ($students as $student) {
            fputcsv($handle, [
                $student->stu_id,
                $student->name,
                $student->phone,
                $student->faculty->fac_name,
                optional($student->year)->year_name ?? 'N/A',
                $student->borrow_qty
            ]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }

    public function generateBarcode($id)
    {
        $student = Student::findOrFail($id);
        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($student->stu_id, $generator::TYPE_CODE_128));

        return view('eichanudom.students.barcode', compact('student', 'barcode'));
    }

    public function generatePDF($id)
    {
        $student = Student::findOrFail($id);
        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($student->stu_id, $generator::TYPE_CODE_128));

        $pdf = PDF::loadView('eichanudom.students.barcode_pdf', compact('student', 'barcode'));
        return $pdf->download('student_barcode.pdf');
    }
}

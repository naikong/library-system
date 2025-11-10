<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendent;
use App\Models\Student;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class AttendentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get search term
        $query = Attendent::query();

        if ($search) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('stu_id', 'LIKE', '%' . $search . '%');
            });
        }

        $attendents = $query->paginate(10); // Paginate results

        return view('kong.attendent.index')->with('attendents', $attendents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attendent = Attendent::find($id);
        $attendent->delete();
        Session::flash('attendent_delete', 'Attendent is deleted.');
        return redirect()->route('attendent.index');
    }

    public function scanPage()
{
    return view('attendent.scan');
}

public function scanBarcode(Request $request)
{
    $barcode = $request->input('barcode');

    // Assuming barcode contains the student ID
    $student = Student::where('stu_id', $barcode)->first();

    if (!$student) {
        return response()->json(['success' => false, 'message' => 'Student not found']);
    }

    $attendent = Attendent::where('student_id', $student->id)
                          ->whereNull('time_out')
                          ->first();

    if ($attendent) {
        // Update time_out
        $attendent->time_out = now();
        $attendent->save();
    } else {
        // Create new record with time_in
        Attendent::create([
            'student_id' => $student->id,
            'date' => now()->toDateString(),
            'time_in' => now(),
        ]);
    }

    return response()->json(['success' => true]);
}

    public function export()
    {
        $attendents = Attendent::all();
        $filename = "attendents.csv";
        $handle = fopen($filename, 'w+');

        // Add BOM to fix UTF-8 in Excel
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($handle, ['ID សិស្ស', 'ឈ្មោះ', 'ជំនាញ', 'កាលបរិច្ឆេទ', 'ម៉ោងចូល', 'ម៉ោងចេញ', 'រយះពេល', 'ស្ថានភាព']);

        foreach ($attendents as $attendent) {
            $timeIn = new \DateTime($attendent->time_in);
            $timeOut = new \DateTime($attendent->time_out);
            $interval = $timeIn->diff($timeOut);

            fputcsv($handle, [
                $attendent->student->stu_id,
                $attendent->student->name,
                $attendent->student->faculty->fac_name,
                $attendent->date,
                $timeIn->format('h:i A'),
                $timeOut->format('h:i A'),
                $interval->format('%hh:%I:%S'),
                $attendent->time_out ? 'បានចេញ' : 'នៅក្នុងបណ្ណាល័យ'
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

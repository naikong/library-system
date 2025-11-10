<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Attendent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'date_range' => 'nullable|string',
        ]);

        $reportType = $validated['report_type'];
        $dateRange = $validated['date_range'];
        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];

        if ($dateRange) {
            $today = Carbon::today();

            if ($dateRange === 'last_7_days') {
                $startDate = $today->copy()->subDays(7);
                $endDate = $today;
            } elseif ($dateRange === 'last_28_days') {
                $startDate = $today->copy()->subDays(28);
                $endDate = $today;
            } elseif ($dateRange === 'last_90_days') {
                $startDate = $today->copy()->subDays(90);
                $endDate = $today;
            }
        }

        $data = $this->fetchReportData($reportType, $startDate, $endDate);

        return view('reports.preview', compact('data', 'reportType', 'startDate', 'endDate'));
    }

    public function export($type, Request $request)
    {
        $reportType = $request->query('report_type');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $data = $this->fetchReportData($reportType, $startDate, $endDate);

        if ($type === 'excel') {
            return $this->exportToCSV($data, $reportType);
        } elseif ($type === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf', compact('data', 'reportType', 'startDate', 'endDate'));
            return $pdf->download($reportType . '_report.pdf');
        }
    }

    private function fetchReportData($reportType, $startDate, $endDate)
{
    switch ($reportType) {
        case 'students':
            return Student::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            })->get();
        case 'books':
            return Book::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            })->get();
        case 'attendances':
            return Attendent::with('student')->whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])->get();
        case 'borrowings':
            return Borrow::with(['student', 'book'])->whereBetween(DB::raw('DATE(borrow_date)'), [$startDate, $endDate])->get();
        default:
            return collect();
    }
}

    private function exportToCSV($data, $reportType)
    {
        $filename = $reportType . ".csv";
        $handle = fopen($filename, 'w+');

        // Add BOM to fix UTF-8 in Excel
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        if ($reportType === 'students') {
            fputcsv($handle, ['ID សិស្ស', 'ឈ្មោះ', 'លេខទូរស័ព្ទ', 'ជំនាញ', 'ឆ្នាំ', 'ចំនួនខ្ចីសៀវភៅ']);
            foreach ($data as $student) {
                fputcsv($handle, [
                    $student->stu_id,
                    $student->name,
                    $student->phone,
                    $student->faculty->fac_name,
                    optional($student->year)->year_name ?? 'N/A',
                    $student->borrow_qty
                ]);
            }
        } elseif ($reportType === 'borrowings') {
            fputcsv($handle, [
                'ID សិស្ស',
                'ឈ្មោះសិស្ស',
                'ឈ្មោះសៀវភៅ',
                'កាលបរិច្ឆេទខ្ចី',
                'កាលបរិច្ឆេទត្រូវត្រឡប់',
                'កាលបរិច្ឆេទសង',
                'ចំនួនខ្ចីសៀវភៅ',
                'ស្ថានភាព',
                'ពិន័យ'
            ]);

            foreach ($data as $item) {
                fputcsv($handle, [
                    $item->student->stu_id,
                    $item->student->name,
                    $item->book->book_name,
                    \Carbon\Carbon::parse($item->borrow_date)->format('d/m/Y'),
                    \Carbon\Carbon::parse($item->deadline_date)->format('d/m/Y'),
                    \Carbon\Carbon::parse($item->return_date)->format('d/m/Y'),
                    $item->qty,
                    $item->status,
                    number_format($item->price_penalty) . '៛'
                ]);
            }
        } elseif ($reportType === 'attendances') {
            fputcsv($handle, ['ID សិស្ស', 'ឈ្មោះ', 'កាលបរិច្ឆេទ', 'ស្ថានភាព']);
            foreach ($data as $attendance) {
                fputcsv($handle, [
                    $attendance->student->stu_id,
                    $attendance->student->name,
                    $attendance->date,
                    $attendance->status
                ]);
            }
        } elseif ($reportType === 'books') {
            fputcsv($handle, ['ចំណងជើងសៀវភៅ', 'រូបភាព', 'លេខសៀវភៅ', 'លេខ ISBN', 'អ្នកនិពន្ធ', 'មុខវិជ្ជា', 'ប្រភេទសៀវភៅ', 'ចំនួន', 'តម្លៃ', 'កាលបរិច្ឆេទ']);
            foreach ($data as $book) {
                // Correctly generate the full URL for the image path
                $imagePath = asset($book->book_photo);

                fputcsv($handle, [
                    $book->book_name,
                    $imagePath,
                    $book->book_number,
                    $book->book_isbn,
                    $book->book_author,
                    $book->subject->subject_name,
                    $book->category->category_name,
                    $book->book_quantity,
                    $book->book_price,
                    Carbon::parse($book->created_at)->format('d-F-Y')
                ]);
            }
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return Response::download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }
}

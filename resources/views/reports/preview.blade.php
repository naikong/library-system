@extends('layout.backend')
@section('content')

<h1>Report Preview</h1>

@if($reportType == 'students')
    @include('reports.partials.students', ['data' => $data])
@elseif($reportType == 'books')
    @include('reports.partials.books', ['data' => $data])
@elseif($reportType == 'attendances')
    @include('reports.partials.attendances', ['data' => $data])
@elseif($reportType == 'borrowings')
    @include('reports.partials.borrowings', ['data' => $data])
@endif

<div class="mt-3">
    <a href="{{ route('reports.export', ['type' => 'excel', 'report_type' => $reportType, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-success">Export to Excel</a>
    <a href="{{ route('reports.index') }}" class="btn btn-secondary">ថយក្រោយ</a>
</div>

@endsection

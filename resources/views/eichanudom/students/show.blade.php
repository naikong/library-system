@extends('layout.backend')
@section('content')
    <h1>ព័ត៌មានលម្អិតរបស់សិស្ស</h1>
    <div class="card">
        <div class="card-header">
            <h2>{{ $student->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>ID សិស្ស:</strong> {{ $student->stu_id }}</p>
            <p><strong>ឈ្មោះ:</strong> {{ $student->name }}</p>
            <p><strong>លេខទូរស័ព្ទ:</strong> {{ $student->phone }}</p>
            <p><strong>ជំនាញ:</strong> {{ $student->faculty->fac_name }}</p>
            <p><strong>ឆ្នាំ:</strong> {{ optional($student->year)->year_name ?? 'N/A' }}</p>
            <p><strong>ចំនួនខ្ចីសៀវភៅ:</strong> {{ $student->borrow_qty }}</p>
        </div>
        <div class="card-footer">
            <a class="btn btn-secondary" href="{{ route('student.list') }}">ថយក្រោយ</a>
        </div>
    </div>
@endsection

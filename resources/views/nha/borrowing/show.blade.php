@extends('layout.backend')

@section('content')
    <h1>ព័ត៌មានលម្អិតការខ្ចីសៀវភៅ</h1>
    <div class="card">
        <div class="card-header">
            <h2>Borrowing Detail for {{ $borrowing->student->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>ឈ្មោះសិស្ស:</strong> {{ $borrowing->student->name }}</p>
            <p><strong>ID សិស្ស:</strong> {{ $borrowing->student->stu_id }}</p>
            <p><strong>ឈ្មោះសៀវភៅ:</strong> {{ $borrowing->book->book_name }}</p>
            <p><strong>កាលបរិច្ឆេទខ្ចី:</strong> {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}</p>
            <p><strong>កាលបរិច្ឆេទត្រូវត្រឡប់:</strong> {{ \Carbon\Carbon::parse($borrowing->deadline_date)->format('d/m/Y') }}</p>
            <p><strong>កាលបរិច្ឆេទសង:</strong> {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y') }}</p>
            <p><strong>ស្ថានភាព:</strong> {{ $borrowing->status }}</p>
            <p><strong>ពិន័យ:</strong> {{ number_format($borrowing->price_penalty) }}៛</p>
        </div>
        <div class="card-footer">
            <a class="btn btn-secondary" href="{{ route('borrow.index') }}">ថយក្រោយ</a>
        </div>
    </div>
@endsection
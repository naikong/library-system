@extends('layout.backend')
@section('content')
    <h1>ព័ត៌មានលម្អិតរបស់សៀវភៅ</h1>
    <div class="card">
        <div class="card-header">
            <h2>{{ $book->book_name }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>រូបភាព:</strong></p>
                    @if($book->book_photo)
                        <img src="{{ asset($book->book_photo) }}" alt="{{ $book->book_name }}" class="img-fluid rounded shadow-sm">
                    @else
                        <img src="https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=" alt="No Image" class="img-fluid rounded shadow-sm">
                    @endif
                </div>
                <div class="col-md-8">
                    <p><strong>ចំណងជើងសៀវភៅ:</strong> {{ $book->book_name }}</p>
                    <p><strong>លេខ​ ISBN:</strong> {{ $book->book_isbn }}</p>
                    <p><strong>អ្នកនិពន្ធ:</strong> {{ $book->book_author }}</p>
                    <p><strong>មុខវិជ្ជា:</strong> {{ $book->subject->subject_name ?? 'N/A' }}</p>
                    <p><strong>ប្រភេទសៀវភៅ:</strong> {{ $book->category->category_name ?? 'N/A' }}</p>
                    <p><strong>តម្លៃ:</strong> ${{ $book->book_price }}</p>
                    <p><strong>លេខសៀវភៅ:</strong> {{ $book->book_number }}</p>
                    <p><strong>ចំនួន:</strong> {{ $book->book_quantity }}</p>
                    <p><strong>កាលបរិច្ឆេទ:</strong> {{ \Carbon\Carbon::parse($book->book_date_update)->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <a class="btn btn-secondary" href="{{ route('book.list') }}">ថយក្រោយ</a>
        </div>
    </div>
@endsection

<style>
    .card {
        margin-top: 20px;
        padding: 20px;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    .card-header h2 {
        margin: 0;
    }
    .card-body {
        padding: 20px;
    }
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .rounded {
        border-radius: 0.25rem;
    }
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>

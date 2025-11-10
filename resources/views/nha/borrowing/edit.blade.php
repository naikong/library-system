@extends('layout.backend')

@section('content')

<h1>ធ្វើបច្ចុប្បន្នភាពការខ្ចីសៀវភៅ</h1>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Something is Wrong</strong>
        <br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('borrow.update', $borrowing->id) }}" class="p-4 shadow-sm rounded">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="borrow_date" class="form-label">កាលបរិច្ឆេទខ្ចី:</label>
        <input type="date" class="form-control" id="borrow_date" name="borrow_date" value="{{ $borrowing->borrow_date }}" required>
    </div>
    <div class="form-group mb-3">
        <label for="return_date" class="form-label">កាលបរិច្ឆេទត្រូវត្រឡប់:</label>
        <input type="date" class="form-control" id="deadline_date" name="deadline_date" value="{{ $borrowing->deadline_date }}" required>        
    </div>
    <div class="form-group mb-3">
        <label for="deadline_date" class="form-label">កាលបរិច្ឆេទសង:</label>
        <input type="date" class="form-control" id="return_date" name="return_date" value="{{ $borrowing->return_date }}">
    </div>
    <div class="form-group mb-3">
        <label for="stu_id" class="form-label">ID សិស្ស:</label>
        <select class="form-control" id="stu_id" name="stu_id" required>
            <option value="">ជ្រើសរើសសិស្ស</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" {{ $borrowing->stu_id == $student->id ? 'selected' : '' }}>
                    {{ $student->stu_id }} - {{ $student->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="book_id" class="form-label">Book ID:</label>
        <select class="form-control" id="book_id" name="book_id" required>
            <option value="">Select a Book</option>
            @foreach ($books as $book)
                <option value="{{ $book->id }}" {{ $borrowing->book_id == $book->id ? 'selected' : '' }}>
                    {{ $book->id }} - {{ $book->book_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="qty" class="form-label">Quantity:</label>
        <input type="number" class="form-control" id="qty" name="qty" value="{{ $borrowing->qty }}" required>
    </div>
    <div class="form-group mb-3">
        <label for="status" class="form-label">Status:</label>
        <select class="form-control" id="status" name="status" required>
            <option value="កំពុងខ្ចី" {{ $borrowing->status == 'កំពុងខ្ចី' ? 'selected' : '' }}>កំពុងខ្ចី</option>
            <option value="បានសង" {{ $borrowing->status == 'បានសង' ? 'selected' : '' }}>បានសង</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary me-2">ធ្វើបច្ចុប្បន្នភាព</button>
    <a class="btn btn-secondary" href="{{ route('borrow.index') }}">ថយក្រោយ</a>
</form>

<!-- Include Toastify CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(Session::has('borrowing_update'))
        Toastify({
            text: "{{ session('borrowing_update') }}",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#4CAF50",
        }).showToast();
        @endif
    });
</script>

@endsection

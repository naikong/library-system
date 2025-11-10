@extends('layout.backend')

@section('content')
    <h1>Create Borrowing Detail</h1>

    @if(Session::has('borrowing_create'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Success!</strong> {{ session('borrowing_create') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Error!</strong> Please fix the following errors:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('borrow.store') }}" class="p-4 shadow-sm rounded">
        @csrf

        <div class="form-group mb-3">
            <label for="borrow_date" class="form-label">កាលបរិច្ឆេទខ្ចី:</label>
            <input type="date" class="form-control" id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="return_date" class="form-label">កាលបរិច្ឆេទត្រូវត្រឡប់:</label>
            <input type="date" class="form-control" id="deadline_date" name="deadline_date" value="{{ old('deadline_date') }}" required>            
        </div>

        {{-- <div class="form-group mb-3">
            <label for="deadline_date" class="form-label">កាលបរិច្ឆេទសង:</label>
            <input type="date" class="form-control" id="return_date" name="return_date" value="{{ old('return_date') }}">
        </div> --}}

        <div class="form-group mb-3">
            <label for="stu_id" class="form-label">ID សិស្ស:</label>
            <select class="form-control" id="stu_id" name="stu_id" required>
                <option value="">ជ្រើសរើសសិស្ស</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ old('stu_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->stu_id }} - {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="book_id" class="form-label">សៀវភៅ:</label>
            <select class="form-control" id="book_id" name="book_id" required>
                <option value="">ជ្រើសរើសសៀវភៅ</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->id }} - {{ $book->book_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="qty" class="form-label">ចំនួន:</label>
            <input type="number" class="form-control" id="qty" name="qty" value="{{ old('qty') }}" required placeholder="បញ្ចូលចំនួន">
        </div>

        {{-- <div class="form-group mb-3">
            <label for="status" class="form-label">Status:</label>
            <input type="text" class="form-control" id="status" name="status" value="{{ old('status', 'Pending') }}" required>
        </div> --}}

        <input type="hidden" name="price_penalty" value="0">

        <button type="submit" class="btn btn-primary me-2">បញ្ចូល</button>
        <a class="btn btn-secondary" href="{{ route('borrow.index') }}">ថយក្រោយ</a>
    </form>
@endsection

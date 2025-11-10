@extends('layout.backend')

@section('content')
    <h1 class="mb-4">កែសម្រួលសៀវភៅ</h1>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Something is Wrong</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('book.update', $book->id) }}" enctype="multipart/form-data" class="p-4 shadow-sm rounded">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="book_name" class="form-label">ចំណងជើងសៀវភៅ:</label>
                <input type="text" class="form-control" id="book_name" name="book_name" value="{{ old('book_name', $book->book_name) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="book_isbn" class="form-label">លេខ​ ISBN:</label>
                <input type="text" class="form-control" id="book_isbn" name="book_isbn" value="{{ old('book_isbn', $book->book_isbn) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="subject_id" class="form-label">មុខវិជ្ជា:</label>
                <div class="input-group">
                    <select class="form-select" id="subject_id" name="subject_id">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $book->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                        Add New
                    </button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">ប្រភេទសៀវភៅ:</label>
                <div class="input-group">
                    <select class="form-select" id="category_id" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        Add New
                    </button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="book_price" class="form-label">តម្លៃ:</label>
                <input type="number" class="form-control" id="book_price" name="book_price" value="{{ old('book_price', $book->book_price) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="book_number" class="form-label">លេខសៀវភៅ:</label>
                <input type="number" class="form-control" id="book_number" name="book_number" value="{{ old('book_number', $book->book_number) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="book_author" class="form-label">អ្នកនិពន្ធ:</label>
                <input type="text" class="form-control" id="book_author" name="book_author" value="{{ old('book_author', $book->book_author) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="book_quantity" class="form-label">ចំនួន:</label>
                <input type="number" class="form-control" id="book_quantity" name="book_quantity" value="{{ old('book_quantity', $book->book_quantity) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="book_photo" class="form-label">រូបភាព:</label>
                <input type="file" class="form-control" id="book_photo" name="book_photo">
            </div>
        </div>
        <div class="d-flex justify-content-start">
            <button type="submit" class="btn btn-primary me-2">រក្សាទុក</button>
            <a class="btn btn-secondary" href="{{ route('book.list') }}">ថយក្រោយ</a>
        </div>
    </form>

    <!-- Modal for adding new subject -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="subjectForm" action="{{ route('subject.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="subject_name" class="form-label">Subject Name:</label>
                            <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Enter Subject Name">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding new category -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name:</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Toastify CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(Session::has('book_create'))
            Toastify({
                text: "{{ session('book_create') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
            }).showToast();
            @endif

            @if(Session::has('book_error'))
            Toastify({
                text: "{{ session('book_error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF0000",
            }).showToast();
            @endif
        });
    </script>
@endsection

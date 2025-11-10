@extends('layout.backend')

@section('content')
    <h1>Create Student</h1>
    @if(Session::has('student_create'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Primary!</strong> {!! session('student_create') !!}
        </div>
    @endif
    @if (count($errors) > 0)
        <!-- Form Error List -->
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
    <form method="POST" action="{{ route('student.store') }}" class="p-4 shadow-sm rounded">
        @csrf
        <div class="form-group mb-3">
            <label for="stu_id" class="form-label">ID សិស្ស:</label>
            <input type="text" class="form-control" id="stu_id" name="stu_id" placeholder="បញ្ចូល ID សិស្ស">
        </div>
        <div class="form-group mb-3">
            <label for="phone" class="form-label">លេខទូរស័ព្ទ:</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="បញ្ចូលលេខទូរស័ព្ទ">
        </div>
        <div class="form-group mb-3">
            <label for="fac_id" class="form-label">ជំនាញ:</label>
            <div class="input-group">
                <select class="form-control" id="fac_id" name="fac_id">
                    <option value="">ជ្រើសរើសមហាវិទ្យាល័យ</option>
                    @foreach ($faculty as $fac)
                        <option value="{{ $fac->id }}">{{ $fac->fac_name }}</option>
                    @endforeach                    
                </select>
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addFacultyModal">
                    Add New
                </button>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="name" class="form-label">ឈ្មោះ:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="បញ្ចូលឈ្មោះ">
        </div>
        <div class="form-group mb-3">
            <label for="year_id" class="form-label">ឆ្នាំ:</label>
            <div class="input-group">
                <select class="form-control" id="year_id" name="year_id">
                    <option value="">ជ្រើសរើសឆ្នាំ</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->year_name }}</option>
                    @endforeach                  
                </select>
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addYearModal">
                    Add New
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary me-2">ចុះឈ្មោះ</button>
        <a class="btn btn-secondary" href="{{ route('student.list') }}">ថយក្រោយ</a>
    </form>

    <!-- Modal for adding new faculty -->
    <div class="modal fade" id="addFacultyModal" tabindex="-1" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacultyModalLabel">Add New Faculty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="facultyForm" action="{{ route('faculty.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="fac_name" class="form-label">Faculty Name:</label>
                            <input type="text" class="form-control" id="fac_name" name="fac_name" placeholder="Enter Faculty Name">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding new year -->
    <div class="modal fade" id="addYearModal" tabindex="-1" aria-labelledby="addYearModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addYearModalLabel">Add New Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="yearForm" action="{{ route('year.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="year_name" class="form-label">Year Name:</label>
                            <input type="text" class="form-control" id="year_name" name="year_name" placeholder="Enter Year Name">
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
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(Session::has('faculty_create'))
            Toastify({
                text: "{{ session('faculty_create') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
            }).showToast();
            @endif

            @if(Session::has('year_create'))
            Toastify({
                text: "{{ session('year_create') }}",
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

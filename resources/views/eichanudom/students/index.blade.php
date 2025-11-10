@extends('layout.backend')
@section('content')

<h1 class="mb-4">តារាងសិស្ស</h1>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div class="d-flex flex-wrap align-items-center gap-2">
        <form id="filter-form" method="GET" action="{{ url('/students') }}" class="d-flex align-items-center">
            <span>បង្ហាញ</span>
            <select class="form-select mx-2" name="per_page" onchange="document.getElementById('filter-form').submit();" style="width: auto;">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
            </select>
            <span>ទិន្ន័យ</span>
        </form>
        <form id="search-form" method="GET" action="{{ url('/students') }}" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control ml-2" placeholder="ស្វែងរក" aria-label="Search" value="{{ request('search') }}" style="width: 200px;">
            <button type="submit" class="btn btn-primary">ស្វែងរក</button>
        </form>
    </div>
    <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
        <a class="btn btn-outline-primary" href="{{ route('students.export') }}">
            <i class="fa fa-file-excel"></i> ទាញយកជា excel
        </a>
        <a class="btn btn-primary" href="{{ url('/student/create') }}">
            <i class="fa fa-plus"></i> បញ្ចូលសិស្ស
        </a>
    </div>
</div>

@if (count($students) > 0)
<div class="table-responsive">
    <table class="table table-striped table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>ID សិស្ស</th>
                <th>ឈ្មោះ</th>
                <th>លេខទូរស័ព្ទ</th>
                <th>ជំនាញ</th>
                <th>ឆ្នាំ</th>
                <th>ចំនួនខ្ចីសៀវភៅ</th>
                <th>ប្រតិបត្តិការ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->stu_id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->phone }}</td>
                <td>{{ $student->faculty->fac_name }}</td>
                <td>{{ optional($student->year)->year_name ?? 'N/A' }}</td>
                <td>{{ $student->borrow_qty }}</td>
                <td class="d-flex gap-2 justify-content-center">
                    <a class="btn btn-sm btn-info" href="{{ route('student.barcode', $student->id) }}">
                        <i class="fa fa-barcode"></i>
                    </a>
                    <a class="btn btn-sm btn-primary" href="{{ url('/student/' . $student->id) }}">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-sm btn-warning" href="{{ url('/student/' . $student->id . '/edit') }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ url('student/' . $student->id) }}" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="d-flex">
        {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
@endif

<!-- Include Toastify CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(Session::has('student_create'))
        Toastify({
            text: "{{ session('student_create') }}",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#4CAF50",
        }).showToast();
        @endif

        @if(Session::has('student_delete'))
        Toastify({
            text: "{{ session('student_delete') }}",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#FF0000",
        }).showToast();
        @endif
    });

    $(".delete").click(function() {
        var form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    });
</script>

@endsection

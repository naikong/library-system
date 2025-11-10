@extends('layout.backend')

@section('content')

<h1 class="mb-4">តារាងសៀវភៅ</h1>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div class="d-flex flex-wrap align-items-center gap-2">
        <form id="filter-form" method="GET" action="{{ url('/book') }}" class="d-flex align-items-center">
            <span>បង្ហាញ</span>
            <select class="form-select mx-2" name="per_page" onchange="document.getElementById('filter-form').submit();" style="width: auto;">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
            </select>
            <span>ទិន្ន័យ</span>
        </form>
        <form id="search-form" method="GET" action="{{ url('/book') }}" class="d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control ml-2" placeholder="ស្វែងរក" aria-label="Search" value="{{ request('search') }}" style="width: 200px;">
            <button type="submit" class="btn btn-primary">ស្វែងរក</button>
        </form>
    </div>
    <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
        <a class="btn btn-outline-primary" href="{{ route('books.export') }}">
            <i class="fa fa-file-excel"></i> ទាញយកជា excel
        </a>
        <a class="btn btn-primary" href="{{ url('/book/create') }}">
            <i class="fa fa-plus"></i> បញ្ចូលសៀវភៅ
        </a>
    </div>
</div>

@if (count($books) > 0)
<div class="table-responsive">
    <table class="table table-striped table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>ចំណងជើងសៀវភៅ</th>
                <th>រូបភាព</th>
                <th>លេខសៀវភៅ</th>
                <th>លេខ​ ISBN</th>
                <th>អ្នកនិពន្ធ</th>
                <th>មុខវិជ្ជា</th>
                <th>ប្រភេទសៀវភៅ</th>
                <th>ចំនួន</th>
                <th>តម្លៃ</th>
                <th>កាលបរិច្ឆេទ</th>
                <th>ប្រតិបត្តិការ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>
                <td>{{ $book->book_name }}</td>
                <td>
                    @if($book->book_photo)
                        <img src="{{ asset($book->book_photo) }}" alt="{{ $book->book_name }}" style="max-width: 100px; height: auto;">
                    @else
                        <img src="https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=" alt="No Image" style="max-width: 100px; height: auto;">
                    @endif
                </td>
                <td>{{ $book->book_number }}</td>
                <td>{{ $book->book_isbn }}</td>
                <td>{{ $book->book_author }}</td>
                <td>{{ optional($book->subject)->subject_name ?? 'N/A' }}</td>
                <td>{{ optional($book->category)->category_name ?? 'N/A' }}</td>
                <td>{{ $book->book_quantity }}</td>
                <td>{{ $book->book_price }}៛</td>
                <td>{{ \Carbon\Carbon::parse($book->created_at)->format('Y-m-d') }}</td>
                <td>
                    <div class="d-flex gap-2 justify-content-center">
                        <a class="btn btn-sm btn-primary" href="{{ url('/book/' . $book->id) }}">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a class="btn btn-sm btn-warning" href="{{ url('/book/' . $book->id . '/edit') }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ url('book/' . $book->id) }}" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>                       
                    </div>
                </td>
            </tr>           
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="d-flex">
        {{ $books->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endif
@endsection

@section('scripts')
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

<style>
    /* Ensure table row hover background color */
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    /* Center images within table cells */
    .table img {
        display: block;
        margin: auto;
    }

    /* Vertical alignment for table cells */
    .table td, .table th {
        vertical-align: middle;
    }

    /* Remove margin from delete form */
    .delete-form {
        margin: 0;
    }

    /* Specific styles for action buttons */
    .table .btn.btn-sm {
        width: 36px;
        height: 36px;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Font size adjustment for icons inside buttons */
    .table .btn.btn-sm .fa {
        font-size: 16px;
    }
</style>

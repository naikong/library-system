@extends('layout.backend')
@section('content')

<style>
    .txt-search {
        border: 2px solid #ccc;
        width: 200px; /* Adjusted width */
        padding: 5px 10px;
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary:hover {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .filter-form, .search-form {
        margin-bottom: 0;
    }

    .status-badge {
        display: inline-block;
        padding: 0.25em 0.75em;
        font-size: 0.875em;
        font-weight: 700;
        color: #fff;
        border-radius: 0.375rem;
    }

    .status-in {
        background-color: #28a745; /* Green for "បានចេញ" */
    }

    .status-out {
        background-color: #6c757d; /* Gray for "នៅក្នុងបណ្ណាល័យ" */
    }
</style>

<h1 class="mb-4">បញ្ជីអវត្ដមានសិស្សចូលអាន​សៀវភៅ</h1>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div class="d-flex flex-wrap align-items-center gap-2">
        <form id="filter-form" method="GET" action="{{ route('attendent.list') }}" class="filter-form d-flex align-items-center">
            <span>បង្ហាញ</span>
            <select class="form-select mx-2" name="per_page" onchange="document.getElementById('filter-form').submit();" style="width: auto;">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
            </select>
            <span>ទិន្ន័យ</span>
        </form>
        <form id="search-form" method="GET" action="{{ route('attendent.list') }}" class="search-form d-flex align-items-center gap-2">
            <input type="text" name="search" class="form-control txt-search" placeholder="ស្វែងរក" aria-label="Search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ស្វែងរក</button>
        </form>
    </div>
    <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
        <a class="btn btn-primary" href="{{ route('attendent.export') }}">
            <i class="fa fa-file-excel"></i> ទាញយកជា excel
        </a>
    </div>
</div>

@if (count($attendents) > 0)
<div class="table-responsive">
    <table class="table table-striped table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>ID សិស្ស</th>
                <th>ឈ្មោះ</th>
                <th>ជំនាញ</th>
                <th>កាលបរិច្ឆេទ</th>
                <th>ម៉ោងចូល</th>
                <th>ម៉ោងចេញ</th>
                <th>រយះពេល</th>
                <th>ស្ថានភាព</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendents as $attendent)
            <tr>
                <td>{{ $attendent->student->stu_id }}</td>
                <td>{{ $attendent->student->name }}</td>
                <td>{{ $attendent->student->faculty->fac_name }}</td>
                <td>{{ $attendent->date }}</td>
                <td>
                    @php
                        $timeIn = new DateTime($attendent->time_in);
                        echo $timeIn->format('h:i A'); // Display time in "hh:mm AM/PM" format
                    @endphp
                </td>
                <td>
                    @php
                        $timeOut = new DateTime($attendent->time_out);
                        echo $timeOut->format('h:i A'); // Display time in "hh:mm AM/PM" format
                    @endphp
                </td>
                <td>
                    @php
                        $interval = $timeIn->diff($timeOut);
                        echo $interval->format('%hh:%I:%S');
                    @endphp
                </td>
                <td>
                    @if ($attendent->time_out)
                        <span class="status-badge status-in">បានចេញ</span>
                    @else
                        <span class="status-badge status-out">នៅក្នុងបណ្ណាល័យ</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="d-flex">
        {{ $attendents->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
@endif

@endsection

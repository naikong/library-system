@extends('layout.backend')
@section('content')

<h1 class="mb-4">Generate Reports</h1>

<div class="card p-4 shadow-sm">
    <form method="POST" action="{{ route('reports.generate') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="report_type" class="form-label">Report Type</label>
            <select name="report_type" id="report_type" class="form-control" required>
                <option value="">Select Report Type</option>
                <option value="students">Students</option>
                <option value="books">Books</option>
                <option value="attendances">Attendance</option>
                <option value="borrowings">Borrowings</option>
            </select>
        </div>
    
        <div class="form-group mb-3">
            <label for="date_range" class="form-label">Date Range</label>
            <select name="date_range" id="date_range" class="form-control">
                <option value="">Select Date Range</option>
                <option value="last_7_days">Last 7 Days</option>
                <option value="last_28_days">Last 28 Days</option>
                <option value="last_90_days">Last 90 Days</option>
                <option value="custom">Custom Range</option>
            </select>
        </div>
    
        <div class="form-group mb-3" id="custom_date_range" style="display: none;">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control">
        </div>
        <div class="form-group mb-3" id="custom_date_range_end" style="display: none;">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control">
        </div>
    
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </div>
    </form>
    
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const dateRangeSelect = document.getElementById('date_range');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const customDateRangeDiv = document.getElementById('custom_date_range');
    const customDateRangeEndDiv = document.getElementById('custom_date_range_end');

    dateRangeSelect.addEventListener('change', function() {
        const today = new Date();
        let startDate, endDate;

        if (this.value === 'last_7_days') {
            startDate = new Date(today);
            startDate.setDate(today.getDate() - 7);
            endDate = today;
        } else if (this.value === 'last_28_days') {
            startDate = new Date(today);
            startDate.setDate(today.getDate() - 28);
            endDate = today;
        } else if (this.value === 'last_90_days') {
            startDate = new Date(today);
            startDate.setDate(today.getDate() - 90);
            endDate = today;
        } else if (this.value === 'custom') {
            customDateRangeDiv.style.display = 'block';
            customDateRangeEndDiv.style.display = 'block';
            startDateInput.value = '';
            endDateInput.value = '';
            return;
        } else {
            customDateRangeDiv.style.display = 'none';
            customDateRangeEndDiv.style.display = 'none';
            startDateInput.value = '';
            endDateInput.value = '';
            return;
        }

        customDateRangeDiv.style.display = 'none';
        customDateRangeEndDiv.style.display = 'none';
        startDateInput.value = startDate.toISOString().split('T')[0];
        endDateInput.value = endDate.toISOString().split('T')[0];
    });
});

</script>

@endsection

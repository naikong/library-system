<table class="table table-bordered" style="width: 100%; margin-top: 20px; font-family: Arial, sans-serif;">
    <thead style="background-color: #f2f2f2; text-align: left;">
        <tr>
            <th style="padding: 10px;">ID សិស្ស</th>
            <th style="padding: 10px;">ឈ្មោះ</th>
            <th style="padding: 10px;">កាលបរិច្ឆេទ</th>
            <th style="padding: 10px;">ស្ថានភាព</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $attendance)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 8px;">{{ $attendance->student->stu_id }}</td>
            <td style="padding: 8px;">{{ $attendance->student->name }}</td>
            <td style="padding: 8px;">{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
            <td style="padding: 8px;">{{ $attendance->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

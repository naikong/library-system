<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2; text-align: left;">
            <th style="padding: 10px; border: 1px solid #ddd;">ID សិស្ស</th>
            <th style="padding: 10px; border: 1px solid #ddd;">ឈ្មោះ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">លេខទូរស័ព្ទ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">ជំនាញ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">ឆ្នាំ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">ចំនួនខ្ចីសៀវភៅ</th>            
        </tr>
    </thead>
    <tbody>
        @foreach($data as $student)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $student->stu_id }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $student->name }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $student->phone }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $student->faculty->fac_name }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $student->year->year_name }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $student->borrow_qty }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

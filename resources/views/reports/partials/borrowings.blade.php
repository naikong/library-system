<table class="table table-bordered" style="width: 100%; margin-top: 20px; font-family: Arial, sans-serif;">
    <thead style="background-color: #f2f2f2; text-align: left;">
        <tr>
            <th style="padding: 10px;">ID សិស្ស</th>
            <th style="padding: 10px;">ឈ្មោះសិស្ស</th>
            <th style="padding: 10px;">ឈ្មោះសៀវភៅ</th>            
            <th style="padding: 10px;">កាលបរិច្ឆេទខ្ចី</th>
            <th style="padding: 10px;">កាលបរិច្ឆេទត្រូវត្រឡប់</th>
            <th style="padding: 10px;">កាលបរិច្ឆេទសង</th>
            <th style="padding: 10px;">ចំនួន</th>
            <th style="padding: 10px;">ស្ថានភាព</th>
            <th style="padding: 10px;">ពិន័យ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $borrow)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 8px;">{{ $borrow->student->stu_id }}</td>
            <td style="padding: 8px;">{{ $borrow->student->name }}</td>            
            <td style="padding: 8px;">{{ $borrow->book->book_name }}</td>
            <td style="padding: 8px;">{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
            <td style="padding: 8px;">{{ \Carbon\Carbon::parse($borrow->deadline_date)->format('d/m/Y') }}</td>
            <td style="padding: 8px;">{{ \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') }}</td>
            <td style="padding: 8px;">{{ $borrow->qty }}</td>
            <td style="padding: 8px;">{{ $borrow->status }}</td>
            <td style="padding: 8px;">{{ number_format($borrow->price_penalty) }}៛</td>
        </tr>
        @endforeach
    </tbody>
</table>

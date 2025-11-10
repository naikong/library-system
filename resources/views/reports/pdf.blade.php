<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Report</h1>

    <table>
        <thead>
            <tr>
                <th>ID សិស្ស</th>
                <th>ឈ្មោះសិស្ស</th>
                <th>ID សៀវភៅ</th>
                <th>ឈ្មោះសៀវភៅ</th>
                <th>កាលបរិច្ឆេទខ្ចី</th>
                <th>កាលបរិច្ឆេទត្រូវត្រឡប់</th>
                <th>កាលបរិច្ឆេទសង</th>
                <th>ស្ថានភាព</th>
                <th>ពិន័យ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $borrow)
            <tr>
                <td>{{ $borrow->student->stu_id }}</td>
                <td>{{ $borrow->student->name }}</td>
                <td>{{ $borrow->book->id }}</td>
                <td>{{ $borrow->book->book_name }}</td>
                <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($borrow->deadline_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') }}</td>
                <td>{{ $borrow->status }}</td>
                <td>{{ number_format($borrow->price_penalty) }}៛</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

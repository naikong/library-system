<!-- resources/views/eichanudom/students/barcode_pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Barcode for Student</title>
</head>
<body>
    <div style="text-align: center;">
        <h1>Barcode for {{ $student->name }}</h1>
        <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode">
    </div>
</body>
</html>

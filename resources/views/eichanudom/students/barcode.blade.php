@extends('layout.backend')

@section('content')
<style>
    .barcode-container {
        text-align: center;
        margin-top: 20px;
    }

    .barcode-image {
        display: block;
        margin: 20px auto;
        padding: 20px;
        border: 2px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .barcode-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .barcode-actions .btn {
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 5px;
    }

    .btn-download-pdf {
        background-color: #dc3545;
        color: #fff;
        border: none;
    }

    .btn-download-pdf:hover {
        background-color: #c82333;
        color: #fff;
    }

    .btn-back {
        background-color: #007bff;
        color: #fff;
        border: none;
    }

    .btn-back:hover {
        background-color: #0056b3;
        color: #fff;
    }
</style>

<h1 class="text-center mb-4">Barcode for {{ $student->name }}</h1>
<div class="barcode-container">
    <img class="barcode-image" src="data:image/png;base64,{{ $barcode }}" alt="Barcode">
    <div class="barcode-actions">
        <a href="{{ route('student.index') }}" class="btn btn-back">
            <i class="fa fa-arrow-left"></i> Back to Students
        </a>
        <a class="btn btn-download-pdf" href="{{ route('student.barcode.pdf', $student->id) }}">
            <i class="fa fa-file-pdf"></i> Download PDF
        </a>
    </div>
</div>
@endsection

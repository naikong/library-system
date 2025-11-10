@extends('layout.backend')
@section('content')

<h1 class="mb-4">Scan Barcode to Add Product</h1>

<div class="mb-4 text-center">
    <p>Use your barcode scanner or the camera on your device to scan the barcode of a student ID. The system will automatically register the attendance time. If the student is already checked in, scanning the barcode again will mark the check-out time.</p>
</div>

<div id="barcode-scanner" style="width: 500px; margin: auto;"></div>
<div id="barcode-reader-results" class="mt-4 text-center"></div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Handle the scanned code here
        console.log(`Code scanned = ${decodedText}`, decodedResult);
        document.getElementById('barcode-reader-results').innerText = `Scanned result: ${decodedText}`;

        // Send the scanned data to your backend
        fetch("{{ route('attendent.scan') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ barcode: decodedText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Attendance marked successfully.');
                location.reload();
            } else {
                alert('Error marking attendance.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "barcode-scanner", { fps: 10, qrbox: 250, formatsToSupport: [Html5QrcodeSupportedFormats.CODE_128] });
    html5QrcodeScanner.render(onScanSuccess);
</script>

@endsection

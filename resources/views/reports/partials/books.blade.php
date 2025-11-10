<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2; text-align: left;">
            <th style="padding: 10px; border: 1px solid #ddd;">ចំណងជើងសៀវភៅ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">រូបភាព</th>
            <th style="padding: 10px; border: 1px solid #ddd;">លេខសៀវភៅ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">លេខ ISBN</th>
            <th style="padding: 10px; border: 1px solid #ddd;">អ្នកនិពន្ធ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">មុខវិជ្ជា</th>
            <th style="padding: 10px; border: 1px solid #ddd;">ប្រភេទសៀវភៅ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">ចំនួន</th>
            <th style="padding: 10px; border: 1px solid #ddd;">តម្លៃ</th>
            <th style="padding: 10px; border: 1px solid #ddd;">កាលបរិច្ឆេទ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $book)
        <tr style="border-bottom: 1px solid #ddd;">
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->book_name }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">
                @if($book->book_photo)
                    <img src="{{ asset($book->book_photo) }}" alt="{{ $book->book_name }}" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                @else
                    <img src="{{ asset('https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=') }}" alt="No Image Available" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                @endif
            </td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->book_number }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->book_isbn }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->book_author }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->subject->subject_name }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->category->category_name }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->book_quantity }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $book->book_price }}</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($book->created_at)->format('d-F-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
